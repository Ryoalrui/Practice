<?php
class IndexController
{
    public function index()
    {
        require_once 'index.html';
    }
    public function public()
    {
        require_once 'view/index.html';
    }
}
