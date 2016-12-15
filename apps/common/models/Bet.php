<?php

namespace Miao\Common\Models;

class Bet extends BaseModel
{

    /**
     *
     * @var integerA
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
     * @var string
     * @Column(type="string", length=10, nullable=true)
     */
    public $codes;

    /**
     *
     * @var string
     * @Column(type="string", length=10, nullable=true)
     */
    public $win_code;

    /**
     *
     * @var integer
     * @Column(type="tinyint", length=1, nullable=true)
     */
    public $is_win;

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
        return 'bet';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Bet[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Bet
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
