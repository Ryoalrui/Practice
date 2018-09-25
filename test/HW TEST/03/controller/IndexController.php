<?php
header('content-type:text/html;charset=UTF-8');
require_once 'model/Database.php';

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
    public function insert()
    {
        $db = new Database();
        $db->insert($_POST);
    }
}
