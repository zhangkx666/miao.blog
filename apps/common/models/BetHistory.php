<?php

namespace Miao\Common\Models;

class BetHistory extends BaseModel
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
     * @var string
     * @Column(type="string", length=10, nullable=true)
     */
    public $bet_code;

    /**
     *
     * @var string
     * @Column(type="string", length=10, nullable=true)
     */
    public $win_code;

    /**
     *
     * @var integer
     * @Column(type="integer", length=2, nullable=true)
     */
    public $code_count;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    public $data_limit;

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
        return 'bet_history';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return BetHistory[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return BetHistory
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
