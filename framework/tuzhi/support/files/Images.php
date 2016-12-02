<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/11/5
 * Time: 10:04
 */

namespace tuzhi\support\files;

/**
Imagick图像处理类
用法:
//引入Imagick物件
if(!defined('CLASS_IMAGICK')){require(Inc.'class_imagick.php');}
$Imagick=new class_imagick();
$Imagick->open('a.gif');
$Imagick->resize_to(100,100,'scale_fill');
$Imagick->add_text('1024i.com',10,20);
$Imagick->add_watermark('1024i.gif',10,50);
$Imagick->save_to('x.gif');
unset($Imagick);
/**/
define('CLASS_IMAGICK',TRUE);
class class_imagick{
    private $image=null;
    private $type=null;
    // 构造
    public function __construct(){}
    // 析构
    public function __destruct(){
        if($this->image!==null){$this->image->destroy();}
    }
    // 载入图像
    public function open($path){
        if(!file_exists($path)){
            $this->image=null;
            return ;
        }
        $this->image=new Imagick($path);
        if($this->image){
            $this->type=strtolower($this->image->getImageFormat());
        }
        $this->image->stripImage();
        return $this->image;
    }
    /**
    图像裁切
    /**/
    public function crop($x=0,$y=0,$width=null,$height=null){
        if($width==null) $width=$this->image->getImageWidth()-$x;
        if($height==null) $height=$this->image->getImageHeight()-$y;
        if($width<=0 || $height<=0) return;
        if($this->type=='gif'){
            $image=$this->image;
            $canvas=new Imagick();
            $images=$image->coalesceImages();
            foreach($images as $frame){
                $img=new Imagick();
                $img->readImageBlob($frame);
                $img->cropImage($width,$height,$x,$y);
                $canvas->addImage($img);
                $canvas->setImageDelay($img->getImageDelay());
                $canvas->setImagePage($width,$height,0,0);
            }
            $image->destroy();
            $this->image=$canvas;
        }else{
            $this->image->cropImage($width,$height,$x,$y);
        }
    }
    /**
    更改图像大小
    参数:
    $width:新的宽度
    $height:新的高度
    $fit: 适应大小
    'force': 把图像强制改为$width X $height
    'scale': 按比例在$width X $height内缩放图片,结果不完全等於$width X $height
    'scale_fill':按比例在$width X $height内缩放图片,没有像素的地方填充顏色$fill_color=array(255,255,255)(红,绿,蓝,透明度[0不透明-127全透明])
    其他:智能模式,缩放图片并从正中裁切$width X $height的大小
    注意:
    $fit='force','scale','scale_fill'时输出完整图像
    $fit=图像方位时输出指定位置部份的图像
    字母与图像的对应关系如下:
    north_west   north   north_east
    west         center        east
    south_west   south   south_east
    /**/
    public function resize_to($width=100,$height=100,$fit='center',$fill_color=array(255,255,255,0)){
        switch($fit){
            case 'force':
                if($this->type=='gif'){
                    $image=$this->image;
                    $canvas=new Imagick();
                    $images=$image->coalesceImages();
                    foreach($images as $frame){
                        $img=new Imagick();
                        $img->readImageBlob($frame);
                        $img->thumbnailImage($width,$height,false);
                        $canvas->addImage($img);
                        $canvas->setImageDelay($img->getImageDelay());
                    }
                    $image->destroy();
                    $this->image=$canvas;
                }else{
                    $this->image->thumbnailImage($width,$height,false);
                }
                break;
            case 'scale':
                if($this->type=='gif'){
                    $image=$this->image;
                    $images=$image->coalesceImages();
                    $canvas=new Imagick();
                    foreach($images as $frame){
                        $img=new Imagick();
                        $img->readImageBlob($frame);
                        $img->thumbnailImage($width,$height,true);
                        $canvas->addImage($img);
                        $canvas->setImageDelay($img->getImageDelay());
                    }
                    $image->destroy();
                    $this->image=$canvas;
                }else{
                    $this->image->thumbnailImage($width,$height,true);
                }
                break;
            case 'scale_fill':
                $size=$this->image->getImagePage();
                $src_width=$size['width'];
                $src_height=$size['height'];
                $x=0;
                $y=0;
                $dst_width=$width;
                $dst_height=$height;
                if($src_width*$height > $src_height*$width){
                    $dst_height=intval($width*$src_height/$src_width);
                    $y=intval(($height-$dst_height)/2);
                }else{
                    $dst_width=intval($height*$src_width/$src_height);
                    $x=intval(($width-$dst_width)/2);
                }
                $image=$this->image;
                $canvas=new Imagick();
                $color='rgba('.$fill_color[0].','.$fill_color[1].','.$fill_color[2].','.$fill_color[3].')';
                if($this->type=='gif'){
                    $images=$image->coalesceImages();
                    foreach($images as $frame){
                        $frame->thumbnailImage($width,$height,true);
                        $draw=new ImagickDraw();
                        $draw->composite($frame->getImageCompose(),$x,$y,$dst_width,$dst_height,$frame);
                        $img=new Imagick();
                        $img->newImage($width,$height,$color,'gif');
                        $img->drawImage($draw);
                        $canvas->addImage($img);
                        $canvas->setImageDelay($img->getImageDelay());
                        $canvas->setImagePage($width,$height,0,0);
                    }
                }else{
                    $image->thumbnailImage($width,$height,true);
                    $draw=new ImagickDraw();
                    $draw->composite($image->getImageCompose(),$x,$y,$dst_width,$dst_height,$image);
                    $canvas->newImage($width,$height,$color,$this->get_type());
                    $canvas->drawImage($draw);
                    $canvas->setImagePage($width,$height,0,0);
                }
                $image->destroy();
                $this->image=$canvas;
                break;
            default:
                $size=$this->image->getImagePage();
                $src_width=$size['width'];
                $src_height=$size['height'];
                $crop_x=0;
                $crop_y=0;
                $crop_w=$src_width;
                $crop_h=$src_height;
                if($src_width*$height > $src_height*$width){
                    $crop_w=intval($src_height*$width/$height);
                }else{
                    $crop_h=intval($src_width*$height/$width);
                }
                switch($fit){
                    case 'north_west':
                        $crop_x=0;
                        $crop_y=0;
                        break;
                    case 'north':
                        $crop_x=intval(($src_width-$crop_w)/2);
                        $crop_y=0;
                        break;
                    case 'north_east':
                        $crop_x=$src_width-$crop_w;
                        $crop_y=0;
                        break;
                    case 'west':
                        $crop_x=0;
                        $crop_y=intval(($src_height-$crop_h)/2);
                        break;
                    case 'center':
                        $crop_x=intval(($src_width-$crop_w)/2);
                        $crop_y=intval(($src_height-$crop_h)/2);
                        break;
                    case 'east':
                        $crop_x=$src_width-$crop_w;
                        $crop_y=intval(($src_height-$crop_h)/2);
                        break;
                    case 'south_west':
                        $crop_x=0;
                        $crop_y=$src_height-$crop_h;
                        break;
                    case 'south':
                        $crop_x=intval(($src_width-$crop_w)/2);
                        $crop_y=$src_height-$crop_h;
                        break;
                    case 'south_east':
                        $crop_x=$src_width-$crop_w;
                        $crop_y=$src_height-$crop_h;
                        break;
                    default:
                        $crop_x=intval(($src_width-$crop_w)/2);
                        $crop_y=intval(($src_height-$crop_h)/2);
                }
                $image=$this->image;
                $canvas=new Imagick();
                if($this->type=='gif'){
                    $images=$image->coalesceImages();
                    foreach($images as $frame){
                        $img=new Imagick();
                        $img->readImageBlob($frame);
                        $img->cropImage($crop_w,$crop_h,$crop_x,$crop_y);
                        $img->thumbnailImage($width,$height,true);
                        $canvas->addImage($img);
                        $canvas->setImageDelay($img->getImageDelay());
                        $canvas->setImagePage($width,$height,0,0);
                    }
                }else{
                    $image->cropImage($crop_w,$crop_h,$crop_x,$crop_y);
                    $image->thumbnailImage($width,$height,true);
                    $canvas->addImage($image);
                    $canvas->setImagePage($width,$height,0,0);
                }
                $image->destroy();
                $this->image=$canvas;
        }
    }
    /**
    添加图片水印
    参数:
    $path:水印图片(包含完整路径)
    $x,$y:水印座标
    /**/
    public function add_watermark($path,$x=0,$y=0){
        $watermark=new Imagick($path);
        $draw=new ImagickDraw();
        $draw->composite($watermark->getImageCompose(),$x,$y,$watermark->getImageWidth(),$watermark->getimageheight(),$watermark);
        if($this->type=='gif'){
            $image=$this->image;
            $canvas=new Imagick();
            $images=$image->coalesceImages();
            foreach($image as $frame){
                $img=new Imagick();
                $img->readImageBlob($frame);
                $img->drawImage($draw);
                $canvas->addImage($img);
                $canvas->setImageDelay($img->getImageDelay());
            }
            $image->destroy();
            $this->image=$canvas;
        }else{
            $this->image->drawImage($draw);
        }
    }
    /**
    添加文字水印
    参数:
    $text:水印文字
    $x,$y:水印座标
    /**/
    public function add_text($text,$x=0,$y=0,$angle=0,$style=array()){
        $draw=new ImagickDraw();
        if(isset($style['font'])) $draw->setFont($style['font']);
        if(isset($style['font_size'])) $draw->setFontSize($style['font_size']);
        if(isset($style['fill_color'])) $draw->setFillColor($style['fill_color']);
        if(isset($style['under_color'])) $draw->setTextUnderColor($style['under_color']);
        if($this->type=='gif'){
            foreach($this->image as $frame){
                $frame->annotateImage($draw,$x,$y,$angle,$text);
            }
        }else{
            $this->image->annotateImage($draw,$x,$y,$angle,$text);
        }
    }
    /**
    图片存档
    参数:
    $path:存档的位置和新的档案名
    /**/
    public function save_to($path){
        $this->image->stripImage();
        switch($this->type){
            case 'gif':
                $this->image->writeImages($path,true);
                return ;
            case 'jpg':
            case 'jpeg':
                $this->image->setImageCompressionQuality($_ENV['ImgQ']);
                $this->image->writeImage($path);
                return ;
            case 'png':
                $flag = $this->image->getImageAlphaChannel();
                // 如果png背景不透明则压缩
                if(imagick::ALPHACHANNEL_UNDEFINED == $flag or imagick::ALPHACHANNEL_DEACTIVATE == $flag){
                    $this->image->setImageType(imagick::IMGTYPE_PALETTE);
                    $this->image->writeImage($path);
                }else{
                    $this->image->writeImage($path);
                }unset($flag);
                return ;
            default:
                $this->image->writeImage($path);
                return ;
        }
    }
    // 直接输出图像到萤幕
    public function output($header=true){
        if($header) header('Content-type: '.$this->type);
        echo $this->image->getImagesBlob();
    }
    /**
    建立缩小图
    $fit为真时,将保持比例并在$width X $height内產生缩小图
    /**/
    public function thumbnail($width=100,$height=100,$fit=true){$this->image->thumbnailImage($width,$height,$fit);}
    /**
    给图像添加边框
    $width: 左右边框宽度
    $height: 上下边框宽度
    $color: 顏色
    /**/
    public function border($width,$height,$color='rgb(220,220,220)'){
        $color=new ImagickPixel();
        $color->setColor($color);
        $this->image->borderImage($color,$width,$height);
    }
    //取得图像宽度
    public function get_width(){$size=$this->image->getImagePage();return $size['width'];}
    //取得图像高度
    public function get_height(){$size=$this->image->getImagePage();return $size['height'];}
    // 设置图像类型
    public function set_type($type='png'){$this->type=$type;$this->image->setImageFormat($type);}
    // 取得图像类型
    public function get_type(){return $this->type;}
    public function blur($radius,$sigma){$this->image->blurImage($radius,$sigma);} // 模糊
    public function gaussian_blur($radius,$sigma){$this->image->gaussianBlurImage($radius,$sigma);} // 高斯模糊
    public function motion_blur($radius,$sigma,$angle){$this->image->motionBlurImage($radius,$sigma,$angle);} // 运动模糊
    public function radial_blur($radius){$this->image->radialBlurImage($radius);} // 径向模糊
    public function add_noise($type=null){$this->image->addNoiseImage($type==null?imagick::NOISE_IMPULSE:$type);} // 添加噪点
    public function level($black_point,$gamma,$white_point){$this->image->levelImage($black_point,$gamma,$white_point);} // 调整色阶
    public function modulate($brightness,$saturation,$hue){$this->image->modulateImage($brightness,$saturation,$hue);} // 调整亮度,饱和度,色调
    public function charcoal($radius,$sigma){$this->image->charcoalImage($radius,$sigma);} // 素描效果
    public function oil_paint($radius){$this->image->oilPaintImage($radius);} // 油画效果
    public function flop(){$this->image->flopImage();} // 水平翻转
    public function flip(){$this->image->flipImage();} // 垂直翻转
}