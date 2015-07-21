<?php

namespace App\Model;

require_once 'BaseModel.php';

class ToDoItem extends BaseModel {

    const STATUS_ACTIVE = 0;
    const STATUS_COMPLETED = 1;

    private static $statuses = array(
                                    ToDoItem::STATUS_ACTIVE => 'Active',
                                    ToDoItem::STATUS_COMPLETED => 'Completed',
                                );

    public static function toStatusName($status) {
        return self::$statuses[$status];
    }

    protected $name;
    protected $status;

    protected static $tableName = 'todo_item';
    protected static $fieldsMap = array('id', 'name', 'status');


    public static function getFieldsMap() {
        return self::$fieldsMap;
    }

    public static function getTableName() {
        return self::$tableName;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function isActive() {
        return $this->status == ToDoItem::STATUS_ACTIVE;
    }

    public function isCompleted() {
        return $this->status == ToDoItem::STATUS_COMPLETED;
    }

}