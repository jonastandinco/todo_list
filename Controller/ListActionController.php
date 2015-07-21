<?php

namespace App\Controller;

use App\Model\DbManager;

require_once 'BaseActionController.php';
require_once dirname(__FILE__) . '/../Model/DbManager.php';
require_once dirname(__FILE__) . '/../Model/ToDoItem.php';

class ListActionController extends BaseActionController {

    public function execute() {
        $manager = DbManager::getInstance();
        $items = $manager->getList('App\Model\ToDoItem');

        $this->renderTemplate('list.php', array('items' => $items));
    }

}