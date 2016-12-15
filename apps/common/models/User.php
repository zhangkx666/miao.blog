<?php

namespace Miao\Common\Models;

use Phalcon\Mvc\Model\Validator\Email as Email;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class User extends BaseModel
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
     * @Column(type="string", length=70, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(type="string", length=70, nullable=false)
     */
    public $user_name;

    /**
     *
     * @var string
     * @Column(type="string", length=70, nullable=false)
     */
    public $nick_name;

    /**
     *
     * @var string
     * @Column(type="string", length=40, nullable=false)
     */
    public $password;

    /**
     *
     * @var string
     * @Column(type="string", length=70, nullable=false)
     */
    public $email;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=true)
     */
    public $phone;

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
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $this->validate(
            new Email(
                [
                    'field'    => 'email',
                    'required' => true,
                ]
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }

        return true;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Miao\Common\Models\Article', 'user_id', ['alias' => 'Article']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }
}
