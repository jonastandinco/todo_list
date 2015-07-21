<?php

/**
 * Basic Database Manager class, no abstraction yet
 * uses Singleton pattern
 */

namespace App\Model;

require_once 'BaseModel.php';

class DbManager {

    /* +++++ SINGLETON IMPLEMENTATION +++++ */
    private static $instance = null;

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new DbManager();
        }

        return self::$instance;
    }

    private function __construct() {
        $this->connect();
    }

    private function __clone() {}
    /* +++++ END SINGLETON IMPLEMENTATION +++++ */

    /**
     * @var \PDO
     */
    private $db;

    /**
     * configure db settings here, should be in a config file
     * @var array
     */
    static private $dbConfig = array(
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'database' => 'test_task',
    );

    /**
     * fetch all model elements
     *
     * @param $modelClass
     * @return array
     */
    public function getList($modelClass) {
        $query = "SELECT * FROM " . $modelClass::getTableName();
        $stmt = $this->runQuery($query);

        $result = array();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result[] = $this->hydrate($modelClass, $row);;
        }

        return $result;
    }

    /**
     * save a new model object
     * @param BaseModel $model
     */
    public function save(BaseModel $model) {
        $values = array();

        foreach ($model::getFieldsMap() as $field) {
            $method = 'get' . ucfirst($field);
            $values[] = "'" . $model->$method() . "'";
        }

        $values = join(',', $values);

        $query = "INSERT INTO " . $model::getTableName() . " ("
               . join(',', $model::getFieldsMap()) . ") VALUE ($values)";

        $this->runQuery($query);

        // insert id and mark as a db-registered object
        $model->setId($this->db->lastInsertId());
        $model->setIsNew(false);
    }

    /**
     * updates the values of a model
     * @param BaseModel $model
     */
    public function update(BaseModel $model) {
        $fieldMap = $model::getFieldsMap();

        // remove id field from map
        if (in_array('id', $fieldMap)) {
            $key = array_search('id', $fieldMap);
            unset($fieldMap[$key]);
        }

        $fieldValues = array();
        foreach ($fieldMap as $field) {
            $method = 'get' . ucfirst($field);
            $fieldValues[] = $field . " = '" . $model->$method() . "'";
        }

        $query = "UPDATE " . $model::getTableName() . " SET "
               . join(', ', $fieldValues) . " "
               . "WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array($model->getId()));
    }

    /**
     * converts raw array data into model object
     *
     * @param $model
     * @param $row
     * @return mixed
     */
    private function hydrate($model, $row) {
        $object = new $model();

        foreach ($model::getFieldsMap() as $field) {
            $method = 'set' . ucfirst($field);
            $object->$method($row[$field]);
            $object->setIsNew(false);
        }

        return $object;
    }

    /**
     * finds a model by ID
     *
     * @param $modelClass
     * @param $id
     * @return mixed|null
     */
    public function find($modelClass, $id) {
        if (!$id) {
            throw new \InvalidArgumentException('Model id is required.');
        }

        $query = "SELECT * FROM " . $modelClass::getTableName()
               . " WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array($id));

        if ($stmt->rowCount()) {
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $this->hydrate($modelClass, $row);
        }

        return null;
    }

    /**
     * performs a query
     *
     * @param $query
     * @return \PDOStatement
     */
    protected function runQuery($query)
    {
        try {
            return $this->db->query($query);
        } catch (\PDOException $e) {
            $this->error('Query failed: ' . $e->getMessage());
        }
    }

    /**
     * connects to the database. This happens only once and only when the DbManager is first
     * requested
     */
    private function connect()
    {
        $dsn = 'mysql:dbname=' . self::$dbConfig['database'] . ';host=' . self::$dbConfig['host'];
        $user = self::$dbConfig['user'];
        $password = self::$dbConfig['password'];

        try {
            $this->db = new \PDO($dsn, $user, $password);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            $this->error('Connection failed: ' . $e->getMessage());
        }
    }

    /**
     * display errors. should be refactored somewhere else
     * @param $message
     */
    private function error($message) {
        echo $message;
        exit;
    }

}