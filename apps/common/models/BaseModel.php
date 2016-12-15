<?php
namespace Miao\Common\Models;

use Phalcon\Mvc\Model;

class BaseModel extends Model
{
    /**
     * create time
     */
    public function beforeCreate()
    {
        $this->created_at = date("Y-m-d H:i:s");
    }

    /**
     * update time
     */
    public function beforeUpdate()
    {
        $this->updated_at = date("Y-m-d H:i:s");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @param boolean $cache 是否用缓存
     * @return Article[]
     */
    public static function find($parameters = null, $cache = false)
    {
        // Convert the parameters to an array
        if (!is_array($parameters)) {
            $parameters = array($parameters);
        }

        // Check if a cache key wasn't passed
        // and create the cache parameters
        if ($cache && !isset($parameters['cache'])) {
            $parameters['cache'] = array(
                "key" => self::_createKey($parameters),
                "lifetime" => 60
            );
        }
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @param boolean $cache 是否用缓存
     * @return Article
     */
    public static function findFirst($parameters = null, $cache = false)
    {
        // Convert the parameters to an array
        if (!is_array($parameters)) {
            $parameters = array($parameters);
        }

        // Check if a cache key wasn't passed
        // and create the cache parameters
        if ($cache && !isset($parameters['cache'])) {
            $parameters['cache'] = array(
                "key" => self::_createKey($parameters),
                "lifetime" => 60
            );
        }
        return parent::findFirst($parameters);
    }

    /**
     * Implement a method that returns a string key based
     * on the query parameters
     *  @param mixed $parameters
     * @return string key
     */
    protected static function _createKey($parameters)
    {
        return md5(json_encode($parameters));
    }
}