<?php
header('content-type:text/html;charset=UTF-8');
require_once 'model/Database.php';

class ShoppingController
{
    public function shopping_list()
    {
        $db = new Database();
        $res = $db->query('SELECT * FROM shopping_cart');
        require_once 'view/shopping_list.html';
    }
    public function add()
    {
        $db = new Database();
        $db->add($_POST);
    }
    public function drop()
    {
        $db = new Database();
        var_dump($db->del($_POST));
    }
}
