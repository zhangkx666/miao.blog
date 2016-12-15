<?php

namespace Miao\Common\Models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Url;

class Comment extends BaseModel
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
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $article_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $comment_id;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $nickname;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=true)
     */
    public $avatar;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $email;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=true)
     */
    public $link;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $user_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $markdown_content;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $html;

    /**
     *
     * @var integer
     * @Column(type="integer", nullable=true)
     */
    public $like_count;

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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('article', 'Miao\Common\Models\Article', 'id', ['alias' => 'Article']);
        $this->belongsTo('user_id', 'Miao\Common\Models\User', 'id', ['alias' => 'User']);
    }

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $this->nickname = trim($this->nickname);
        $this->link = trim($this->link);

        $validation = new Validation();
        $validation->add(['article_id', 'nickname', 'email', 'markdown'], new PresenceOf([
            'message' => [
                'article_id' => '提交异常，没有获取到 article_id',
                'nickname' => '昵称 不能为空',
                'email' => 'Email 不能为空',
                'markdown' => '评论内容 不能为空'
            ]
        ]));
        $validation->add("email", new Email([
            "message" => "Email格式不正确"
        ]));
        $validation->add("link", new Url([
            "message" => "网址格式不正确",
            "allowEmpty" => true
        ]));
        return $this->validate($validation);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'comment';
    }
}
