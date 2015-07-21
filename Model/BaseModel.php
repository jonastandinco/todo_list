<?php

namespace App\Model;

abstract class BaseModel
{

    protected $id;
    protected $isNew = true;

    protected static $tableName;
    protected static $fieldsMap;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function isNew() {
        return (bool) $this->isNew;
    }

    public function setIsNew($isNew) {
        $this->isNew = (bool) $isNew;
    }

    abstract public static function getFieldsMap() ;
    abstract public static function getTableName();

}