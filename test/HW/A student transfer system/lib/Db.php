<?php
header('content-type:text/html;charset=UTF-8');

class Db
{
    public $mysqli;
    public $rname;
    public $rnumber;
    public $email;
    public $money;
    public $info;
    public $face;
    public $data;

    public function __construct()
    {
        //进行数据库初始化连接，并且设置字符集
        $this->mysqli = new mysqli('localhost', 'root', '你的密码', '你的数据库');
        $this->mysqli->query('set names utf8');
    }

    /**
     * [//数据库针对注册，进行表单传值插入操作]
     * @method insert
     * @return [string]
     */
    public function insert()
    {
        //数据库插入操作
        $this->stmt = $this->mysqli->prepare('INSERT 你的数据表(name,number,email,money,info,face) VALUE(?,?,?,?,?,?)');
        $this->stmt->bind_param('sisiss', $this->rname, $this->rnumber, $this->email, $this->money, $this->info, $this->face);
        if ($this->stmt->execute()) {
            return '数据库资料插入成功';
        }
    }

    /**
     * [数据库针对的登录，进行相关字段的查询操作]
     * @method query
     * @return [boolean]
     */
    public function query()
    {
        $this->res = $this->mysqli->query('SELECT name,number FROM 你的数据表');
        $this->data = $this->res->fetch_all(MYSQLI_ASSOC);
        return true;
    }
}
