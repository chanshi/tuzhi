<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 10:33
 */

namespace tuzhi\db;


use tuzhi\base\BObject;

/**
 * Class Transaction
 * @package tuzhi\db
 * @see Yii2
 */
class Transaction extends BObject
{
    /**
     *
     */
    const READ_UNCOMMITTED = 'READ UNCOMMITTED';

    /**
     *
     */
    const READ_COMMITTED = 'READ COMMITTED';

    /**
     *
     */
    const REPEATABLE_READ = 'REPEATABLE READ';

    /**
     *
     */
    const SERIALIZABLE = 'SERIALIZABLE';

    /**
     * @var
     */
    public $db;

    /**
     * @var int
     */
    private $level = 0;

    /**
     * @param string $isolation
     * @return bool
     */
    public function begin( $isolation = Transaction::REPEATABLE_READ )
    {
        if( !$this->db->isActivity()  ){
            $this->db->open();
        }

        if( $this->level == 0 ){
            $this->db->getSchema()
                ->setTransactionLevel( $isolation );

            $this->db->pdo->beginTransaction();
            $this->level = 1;
            return true;
        }

        $this->db->getSchema()
            ->createSavePoint( 'POINT_'.$this->level );
        $this->level++;
        return true;
    }

    /**
     * @return bool
     */
    public function rollback()
    {
        if( ! $this->db->isActivity() ){
            return false;
        }

        $this->level--;
        if($this->level == 0){
            $this->db->pdo->rollback();
            return true;
        }

        $this->db->getSchema()
            ->rollBackSavePoint('POINT_'.$this->level);
        return true;
    }

    /**
     * @return bool
     */
    public function commit()
    {
        if( ! $this->db->isActivity() ){
            return false;
        }

        $this->level--;
        if($this->level == 0){
            $this->db->pdo->commit();
            return true;
        }

        $this->db->getSchema()
            ->releaseSavePoint('POINT_'.$this->level);
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }
}