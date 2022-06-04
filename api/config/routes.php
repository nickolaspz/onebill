<?php
$requestURI = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

$controller = isset($requestURI[1]) ? $requestURI[1] : null;
$action = isset($requestURI[2]) ? $requestURI[2] : null;
$args = isset($requestURI[3]) ? $requestURI[3] : null;

if (!$controller || !$action) {
    die('Page does not exist.');
}

$session->write('request.controller', $controller);
$session->write('request.action', $action);
$session->write('request.args', $args);

if ($_GET) {
    $session->write('request.query', $_GET);
    $session->write('request.GET', true);
} else if ($_POST) {
    $session->write('request.POST', true);
}