<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/1
 * Time: 10:54
 */

namespace tuzhi\model\validators\rule;

use tuzhi\model\validators\Verify;

/**
 * Class CompareValid
 * @package tuzhi\model\validators\rule
 */
class CompareValid extends Verify
{

    /**
     * @var
     */
    public $op = '==';

    /**
     * @var
     */
    public $value;

    /**
     * @var
     */
    public $opAttribute;


    /**
     * @return mixed
     */
    protected function getCompareValue()
    {
        return $this->value
            ? $this->value
            : $this->getAttribute($this->opAttribute);
    }

    /**
     * @return bool
     */
    protected function check()
    {

        if( $this->getAttribute() && $this->getCompareValue() ) {
            switch( $this->op )
            {
                case '==' :
                    $status = $this->getAttribute() == $this->getCompareValue() ;
                    if( ! $status ){
                        $this->addError( '{label} 不符合 比较 ==' );
                    }
                    return $status;
                    break;
                case '===' :
                    $status = $this->getAttribute() === $this->getCompareValue() ;
                    if( ! $status ){
                        $this->addError( '{label} 不符合 比较 ===' );
                    }
                    return $status;
                    break;
                case '>' :
                    $status = $this->getAttribute() > $this->getCompareValue() ;
                    if( ! $status ){
                        $this->addError( '{label} 不符合 比较 >' );
                    }
                    return $status;
                    break;
                case '>=' :
                    $status = $this->getAttribute() >= $this->getCompareValue() ;
                    if( ! $status ){
                        $this->addError( '{label} 不符合 比较 >=' );
                    }
                    return $status;
                    break;
                case '<' :
                    $status = $this->getAttribute() < $this->getCompareValue() ;
                    if( ! $status ){
                        $this->addError( '{label} 不符合 比较 <' );
                    }
                    return $status;
                    break;
                case '<=' :
                    $status = $this->getAttribute() <= $this->getCompareValue() ;
                    if( ! $status ){
                        $this->addError( '{label} 不符合 比较 <=' );
                    }
                    return $status;
                    break;
                case '!=' :
                    $status = $this->getAttribute() != $this->getCompareValue() ;
                    if( ! $status ){
                        $this->addError( '{label} 不符合 比较 !=' );
                    }
                    return $status;
                    break;
                case 'in' :
                    $status = in_array( $this->getAttribute() ,$this->getCompareValue() ) ;
                    if( ! $status ){
                        $this->addError( '{label} 不在规定的范围内' );
                    }
                    return $status;
                    break;
                case 'notIn' :
                    $status = ! in_array( $this->getAttribute() ,$this->getCompareValue() );
                    if( ! $status ){
                        $this->addError( '{label} 超过规定的范围' );
                    }
                    return $status;
                    break;
                default :
                    return true;
            }
        }
        return true;
    }

    /**
     * @return bool
     */
    public function verify()
    {
        return $this->check();
    }
}