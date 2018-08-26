<?php
header('content-type:text/html;charset=UTF-8');
require_once 'model/Database.php';

class ProductController
{
    public function course_list()
    {
        require_once 'view/list.html';
    }
    public function insert()
    {
        $db = new Database();
        $db->insert($_POST);
        // print_r($_POST);
        // var_dump($db);
    }
}
