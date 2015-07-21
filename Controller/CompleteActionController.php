<?php

namespace App\Controller;

use App\Model\DbManager;
use App\Model\ToDoItem;

require_once 'BaseActionController.php';
require_once dirname(__FILE__) . '/../Model/DbManager.php';
require_once dirname(__FILE__) . '/../Model/ToDoItem.php';

class CompleteActionController extends BaseActionController {

    private $errMessage;

    /**
     * @var App\Model\ToDoItem
     */
    private $item;

    public function validate() {
        if (!isset($this->params['id'])) {
            $this->errMessage = 'Please pass the ID of the item';
            return false;
        }

        $manager = DbManager::getInstance();
        $this->item = $manager->find('App\Model\ToDoItem', $this->params['id']);

        if (!$this->item instanceof ToDoItem) {
            $this->errMessage = "Cannot find item";
            return false;
        }

        if ($this->item->isCompleted()) {
            $this->errMessage = "Item is already completed.";
            return false;
        }

        return true;
    }

    public function handleFailure() {
        echo $this->errMessage;
        exit;
    }

    public function execute() {
        $this->item->setStatus(ToDoItem::STATUS_COMPLETED);

        $manager = DbManager::getInstance();
        $manager->update($this->item);

        header('Location: index.php?action=list');
    }

}