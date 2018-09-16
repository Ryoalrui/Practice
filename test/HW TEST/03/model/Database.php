<?php
//Model类
header('content-type:text/html;charset=UTF-8');

class Database
{
    protected $pdo;
    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=hw', 'root', '1010LING');
        $this->pdo->exec('set names utf8');
    }
    //完成数据的插入操作
    /*
     *$bind的形态['username'=>?,'password'=>?,'sex'=>?]
     */
    public function insert($bind)
    {
        $sql = 'INSERT course(name,price,direction,intro,level) value(?,?,?,?,?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $bind['name'], PDO::PARAM_STR);
        $stmt->bindValue(2, $bind['price'], PDO::PARAM_STR);
        $stmt->bindValue(3, $bind['direction'], PDO::PARAM_STR);
        $stmt->bindValue(4, $bind['intro'], PDO::PARAM_STR);
        $stmt->bindValue(5, $bind['level'], PDO::PARAM_STR);
        $stmt->execute();
    }
    //完成数据的查找操作
    /*
     *@param string $sql,SQL查询语句
     */
    public function query($sql)
    {
        $stmt = $this->pdo->query($sql);
        $rowset = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rowset;
    }
    public function add($bind)
    {
        $sql = 'INSERT shopping_cart(name,price) value(?,?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $bind['coures_name'], PDO::PARAM_STR);
        $stmt->bindValue(2, $bind['coures_price'], PDO::PARAM_STR);
        $stmt->execute();
    }
    public function del($bind)
    {
        $sql = "DELETE FROM shopping_cart WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $bind['course_id'], PDO::PARAM_INT);
        $stmt->execute();
    }
    public function search($key)
    {
        $sql = "SELECT * FROM course WHERE direction=:direction";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":direction", $key, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
