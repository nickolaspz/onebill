<?php
// require 'app' . DS . 'vendors' . DS . 'hal-explorer';
abstract class Controller
{
    protected $view;
    protected $session;
    protected $request;

    function __construct(View $view = null, Session $session = null, Request $request = null)
    {
        $this->view = $view;
        $this->request = $request;
        $this->session = $session;
    }
}