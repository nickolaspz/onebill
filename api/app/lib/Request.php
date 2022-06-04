<?php

class Request
{
    var $controller;
    var $action;
    var $args;
    var $query;
    var $GET;
    var $POST;

    function __construct(array $request = array())
    {
        foreach (get_object_vars($this) as $key => $param) {
            if (isset($request['request'][$key])) {
                $this->$key = $request['request'][$key];
            }
        }
    }
}