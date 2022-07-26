<?php

namespace e2c\mvc\DBModel;

use e2c\mvc\Model;

abstract class DBModel extends Model  implements  ORMInterFace
{
    use ORMTrait;

    /**
     * @var array
     */
    public array $attributes = [];

    /**
     * @return string
     */
    public function primaryKey(): string
    {
        return $this->primaryKey??'id';
    }


    /**
     * @param $propertyName
     * @param $value
     * @return void
     */
    public function __set($propertyName , $value)
    {
        $this->attributes[$propertyName] = $value;
    }


    /**
     * @param $name
     * @return mixed|void
     */
    public function __get($name)
    {
        if(array_key_exists ( $name , $this->attributes)) {
            return $this->attributes[$name];
        }
    }

    /**
     * Load All Request data from user input
     * Load
     * @param $data
     */
    public function loadUserData( $data)
    {
        foreach ($data as $key=>$value) {
            if(in_array($key,$this->fillable)) {
                $status = $this->haveAnyMutators($key,$value);
                if(!$status){
                    $this->{$key}= $value ;
                }

            }
        }

    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function haveAnyMutators($key, $value) : bool
    {
        $functionName = 'set'.str_replace(' ','',ucwords(str_replace ( '_' , ' ' , $key))).'Attribute';
          if(method_exists($this,$functionName)){
              $this->{$functionName}($value);
              return true;
          }
        return false;
    }
}