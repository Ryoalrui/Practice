<?php
header('content-type:text/html;charset=UTF-8');
/*数据库处理类*/

class Db
{
    public $mysqli;
    public $name;
    public $addr;


    public function __construct()
    {
        //进行数据库初始化连接，并且设置字符集
        $this->mysqli = new mysqli('localhost', 'root', '1010LING', 'hw');
        $this->mysqli->query('set names utf8');
    }

    /**
     * [数据库插入操作]
     * @method insert
     * @return [string]
     */
    public function insert()
    {
        //数据库插入操作
        $this->stmt = $this->mysqli->prepare('INSERT pic_upload_system(name,addr) VALUE(?,?)');
        $this->stmt->bind_param('ss', $this->name, $this->addr);
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
        $this->res = $this->mysqli->query('SELECT name,number FROM pic_upload_system');
        $this->data = $this->res->fetch_all(MYSQLI_ASSOC);
        return true;
    }
}
