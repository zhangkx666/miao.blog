<?php

namespace Miao\Common\Models;

class Lottery extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $date;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=true)
     */
    public $period;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    public $code1;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    public $code2;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    public $code3;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    public $code4;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    public $code5;

    /**
     * @var integer
     *  @Column(type="integer", length=1, nullable=true)
     */
    public $group3_before;

    /**
     * @var integer
     *  @Column(type="integer", length=1, nullable=true)
     */
    public $group3_after;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $created_at;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $updated_at;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'lottery';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Lottery[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters, true);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Lottery
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters, true);
    }

    /**
     * 获取属性
     * @param $attr_name
     * @return mixed
     */
    public function attr($attr_name) {
        return $this->readAttribute($attr_name);
    }
}
