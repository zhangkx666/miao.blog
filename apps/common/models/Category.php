<?php

namespace Miao\Common\Models;

use Phalcon\Mvc\Model\Message;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class Category extends BaseModel
{

    use LogicDelete;

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
     * @Column(type="integer", length=11, nullable=true)
     */
    public $parent_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $title;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $sort;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $is_show;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $show_in_nav;

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
        $this->useDynamicUpdate(true);
        $this->hasMany('id', 'Miao\Common\Models\Article', 'category_id', ['alias' => 'Article']);
        $this->hasMany('id', 'Miao\Common\Models\Category', 'parent_id', ['alias' => 'Children']);
        $this->belongsTo("parent_id", 'Miao\Common\Models\Category', "id", ['alias' => 'Parent']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'category';
    }

    /**
     * before save
     */
    public function beforeSave()
    {
        // parent_id allows null
        if (empty($this->parent_id)) $this->parent_id = null;

        // trim
        $this->title = trim($this->title);
        $this->name = trim($this->name);

        // sort
        if (!is_numeric($this->sort)) $this->sort = 99;
    }

    /**
     * before delete
     * @return bool
     */
    public function beforeDelete()
    {
        $success = true;
        $article_count = $this->article->count();
        if ($article_count > 0) {
            $this->appendMessage(new Message("有 {$article_count} 个文章属于此分类，不能删除"));
            $success = false;
        }
        $sub_cat_count = $this->children->count();
        if ($sub_cat_count > 0) {
            $this->appendMessage(new Message("有 {$sub_cat_count} 个分类的父级分类为此分类，不能删除"));
            $success = false;
        }
        return $success;
    }

    /**
     * @var array invalid insert fields
     */
    public $insert_fields = ['title', 'name', 'sort', 'is_show', 'show_in_nav', 'parent_id'];

    /**
     * @var array invalid update fields
     */
    public $update_fields = ['title', 'name', 'sort', 'is_show', 'show_in_nav', 'parent_id'];

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validation = new Validation();
        $validation->add(['title', 'name'], new PresenceOf([
            'message' => [
                'title' => '名称 不能为空',
                'name' => '名称（地址用） 不能为空'
            ]
        ]));

        $validation->setFilters("name", "trim");
        $validation->setFilters("title", "trim");

        return $this->validate($validation);
    }
}
