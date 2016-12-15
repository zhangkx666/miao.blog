<?php

namespace Miao\Common\Models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;

class Article extends BaseModel
{
    use LogicDelete;

    /**
     * 是否显示：1：是
     */
    const IS_SHOW = 1;

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
    public $category_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $title;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $link;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $desc;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $user_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $markdown;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $html;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $cover_img_url;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    public $is_show;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $view_count;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $like_count;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $comment_count;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $deleted_at;

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
        $this->belongsTo('category_id', 'Miao\Common\Models\Category', 'id', ['alias' => 'Category']);
        $this->belongsTo('user_id', 'Miao\Common\Models\User', 'id', ['alias' => 'User']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'article';
    }

    /**
     * before save
     */
    public function beforeSave()
    {
        // trim
        $this->title = trim($this->title);
        $this->desc = trim($this->desc);
        $this->link = trim($this->link);

        // if link filed is numeric, clear it
        if (is_numeric($this->link))
            $this->link = null;
    }

    /**
     * @var array invalid insert fields
     */
    public $insert_fields = ['title', 'desc', 'link', 'is_show', 'category_id', 'markdown', 'html', 'user_id'];

    /**
     * @var array invalid update fields
     */
    public $update_fields = ['title', 'desc', 'link', 'is_show', 'category_id', 'markdown', 'html', 'user_id'];

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $this->title = trim($this->title);
        $this->link = trim($this->link);

        $validation = new Validation();
        $validation->add(['title'], new PresenceOf([
            'message' => [
                'title' => '标题 不能为空'
            ]
        ]));
        $validation->add("link", new Uniqueness([
            "message" => "链接不能重复！",
            "allowEmpty" => true
        ]));
        return $this->validate($validation);
    }
}
