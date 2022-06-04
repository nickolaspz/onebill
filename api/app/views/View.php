<?php

class View
{
    public $vars;
    private $viewDirectory;

    function __construct()
    {
        $this->vars = [];
        $this->viewDirectory = 'app' . DS .'views' . DS;
    }

    /**
     * Sets the template/view to render.
     * @param string $templateFile
     * @param array $vars
     * @return view
     */
    public function render($templateFile, array $vars = array())
    {
        ob_start();
        extract($vars);
        require $this->_getTemplate($templateFile);
        return ob_get_clean();
    }

    /**
     * Sets view variables
     * @param string $name
     * @param $value
     */
    public function set($name, $value)
    {
        $this->vars[$name] = $value;
    }

    /**
     * Verifies and includes template file to render.
     * If file does not exist, displays error page instead.
     * @param string $templateFile
     */
    private function _getTemplate($templateFile)
    {
        $templateFile = $this->viewDirectory . $templateFile . '.php';

        // File not found - Error 500
        if (!file_exists($templateFile)) {
            $templateFile = $this->viewDirectory . 'error.php';
        }

        return $templateFile;
    }
}