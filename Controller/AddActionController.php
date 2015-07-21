<?php

namespace App\Controller;

use App\Model\DbManager;
use App\Model\ToDoItem;

require_once 'BaseActionController.php';
require_once dirname(__FILE__) . '/../Model/DbManager.php';
require_once dirname(__FILE__) . '/../Model/ToDoItem.php';

class AddActionController extends BaseActionController {

    public function execute() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $item = new ToDoItem();

            $item->setName(trim($_POST['name']));
            $item->setStatus(ToDoItem::STATUS_ACTIVE);

            $manager = DbManager::getInstance();
            $manager->save($item);

            header('Location: index.php?action=list');
        }

        $this->renderTemplate('form_new.php');
    }

}