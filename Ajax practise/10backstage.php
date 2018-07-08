<?php
header('content-type:text/html;charset=UTF-8');

//实例化数据库
$pdo=new pdo('mysql:host=localhost;dbname=mydb', '用户名', '用户密码');
$pdo->exec('set names utf8');//记得设置字符集否则显示乱码
$num=isset($_POST['number']) ? (int)$_POST['number'] : 1 ;

//判断页面当前的数量是否已经超过总数
$res=$pdo->query('SELECT COUNT(*) AS COUNT FROM tdb_goods_types');//查询数据总数
$NUM=$res->fetch(PDO::FETCH_ASSOC);//得到数据库里的数据总数

//A.如果超过，则返回超过信息
if ($num > $NUM['COUNT']) {
    die(json_encode(array('msg'=>'对不起，超过最大数量','code'=>400)));
}

//B.如果刚好等于，代表取完数据，返回相对应的提示信息
if ($num == $NUM['COUNT']) {
    die(json_encode(array('msg'=>'数据至此已全部取完了','code'=>300)));
}

//C.如果已取出的数量小于数据库里的数据量，则继续从数据库内选中信息，输出到前端
if ($num < $NUM['COUNT']) {
    $arr=$pdo->query("SELECT type_name,type_id FROM tdb_goods_types LIMIT ".$num.",1");//血的教训，字符串拼接要留意空格
    $res=$arr->fetchAll(PDO::FETCH_ASSOC);

    $msg='';
    foreach ($res as $key => $value) {
        $msg.='<tr><td>'.$value['type_name'].'</td><td>'.$value['type_id'].'</td></tr>';
    }
    if ($NUM['COUNT']>=$num+1) {
        die(json_encode(array('msg'=>$msg,'code'=>200)));//根据遍历的填充情况，将其作为json字符串输出到前端
    }
}
