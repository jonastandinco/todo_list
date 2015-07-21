<?php

/**
 * Basic front controller
 */
namespace App;

use App\Controller\ListActionController;
use App\Controller\AddActionController;
use App\Controller\CompleteActionController;
use App\Controller\ActivateActionController;

class App {

    private $action;
    private $params;

    static private $validActions = array('add', 'list', 'complete', 'activate');

    public function __construct($params) {
        if (!isset($params['action'])) {
            $params['action'] = 'list';
        }

        if (!in_array($params['action'], self::$validActions)) {
            throw new \InvalidArgumentException('Unrecognized action');
        }

        $this->params = $params;
        $this->action = trim($this->params['action']);
    }

    /**
     * Basic routing
     */
    public function execute() {
        switch ($this->action) {
            case 'add':
                require_once 'Controller/AddActionController.php';
                $controller = new AddActionController($this->params);
                break;

            case 'list':
                require_once 'Controller/ListActionController.php';
                $controller = new ListActionController($this->params);
                break;

            case 'complete':
                require_once 'Controller/CompleteActionController.php';
                $controller = new CompleteActionController($this->params);
                break;

            case 'activate':
                require_once 'Controller/ActivateActionController.php';
                $controller = new ActivateActionController($this->params);
                break;
        }

        $controller->run();
    }

}

$app = new App($_GET);
$app->execute();


