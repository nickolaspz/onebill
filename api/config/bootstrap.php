<?php
define('onebill', true);

define('Config', array(
    'debug' => true
));

// Error reporting
require 'config' . DS . 'errorhandler.php';

// Import Nik extract tool
include WWW_ROOT . '/app/utility/Nik/Nik.php';

// Create Session
require 'app' . DS .'lib' . DS .'Session.php';
$session = new Session;

// Create View
require 'app' . DS .'views' . DS .'View.php';
$view = new View;

// Import Routes
require 'config' . DS .'routes.php';

// Create Request
require 'app' . DS .'lib' . DS .'Request.php';
$request = new Request($session->read('request'));

// Custom debug function
function debug($var)
{
    echo '<div style="width: 100%;">';
        echo '<pre style="background-color: white; border-radius: 5px; padding: 15px; display: inline-block;">';
            echo '<b><p>' . debug_backtrace()[0]['file'] . ' (Line: ' . debug_backtrace()[0]['line'] . ')</p></b>';
            echo '<br>';
            if ($var == null) {
                echo 'null';
            } else {
                print_r($var);
            }
        echo '</pre>';
    echo '</div>';
}
