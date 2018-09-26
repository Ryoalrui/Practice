<?php
header('content-type:text/html;charset=UTF-8');
require_once 'model/Database.php';
require_once 'lib/Pagination.php';

class ProductController
{
    public function course_list()
    {
        $db = new Database();
        switch ($_GET['key']) {
          case 'PHP':
          $res = $db->search('PHP');
          break;
          case 'Java':
          $res = $db->search('Java');
          break;
          case 'Html/css':
          $res = $db->search('Html/css');
          break;
          case 'Python':
          $res = $db->search('Python');
          break;
          case 'Android':
          $res = $db->search('Android');
          break;
          case 'Ios':
          $res = $db->search('Ios');
          break;
          default:
          $number = $db->query('SELECT COUNT(*) AS nums FROM course');
          $page = new Page(6, $number[0]['nums']);
          $res = $db->query('SELECT * FROM course LIMIT '.$page->limit());
          $page->allUrl();
          break;
        }
        require_once 'view/list.html';
    }
}
