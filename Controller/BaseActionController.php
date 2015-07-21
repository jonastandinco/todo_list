<?php

namespace App\Controller;

abstract class BaseActionController {

    protected $params;

    abstract public function execute();

    /**
     * query parameters are injected better to use request object
     * @param array $params
     */
    public function __construct($params = array()) {
        $this->params = $params;
    }

    /**
     * controller flow
     */
    public function run() {
        if ($this->validate()) {
            $this->execute();
        } else {
            $this->handleFailure();
        }
    }

    /**
     * handles basic validation
     * @return bool
     */
    protected function validate() {
        return true;
    }

    /**
     * handles basic validation failure
     * @return bool
     */
    protected function handleFailure() {
        return true;
    }

    /**
     * basic 2-step templating system
     *
     * @param $templateName
     * @param array $templateVars
     */
    protected function renderTemplate($templateName, $templateVars = array()) {
        $templateDir = dirname(__FILE__)
                     . DIRECTORY_SEPARATOR . '..'
                     . DIRECTORY_SEPARATOR . 'Template';
        $template = $templateDir . DIRECTORY_SEPARATOR . $templateName;

        extract($templateVars);

        ob_start();
            include($template);
            $contents = ob_get_contents();	// Get the contents of the buffer
        ob_end_clean();

        include $templateDir . DIRECTORY_SEPARATOR . 'layout.php';
    }

}