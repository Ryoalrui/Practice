<?php
parse_str($_POST['postData'], $post);
if (!preg_match('/^1\d{10}$/', $post['telphone'])) {
    echo json_encode(['code'=>'wrong','sign'=>'telphone']);
    // return ;
}
if ($post['code']!='123456') {
    echo json_encode(['code'=>'wrong','sign'=>'code']);
    return ;
}
if (!preg_match('/^.{6,16}$/', $post['password'])) {
    echo json_encode(['code'=>'wrong','sign'=>'password']);
    return ;
}
if ($post['c_password']!=$post['password']) {
    echo json_encode(['code'=>'wrong','sign'=>'c_password']);
    return ;
}
if (!preg_match('/^[\x80-\xff]{6,18}$/', $post['name'])) {//汉字在正则表达式内依旧是一个中文字符占3个字符位
    echo json_encode(['code'=>'wrong','sign'=>'name']);
    return ;
}
if (!preg_match('/^\d{17}[\d|X]$/', $post['idcard'])) {//修正身份证识别码最后一位为X的bug
    echo json_encode(['code'=>'wrong','sign'=>'idcard']);
    return ;
}
if (!preg_match('/^[\da-z]+([\._\-]*[\da-z]+)*@[\da-z]+([\.\-][\da-z]+)*\.[a-z]+$/', $post['email'])) {
    echo json_encode(['code'=>'wrong','sign'=>'email']);
    return ;
}

//将合法数据写入数据库
echo json_encode(['code'=>'right']);

//UTF8编码下汉字Unicode编码范围：\x80-\xff

//array (size=1)
//'postData' => string 'telphone=111111&password=&c_password=&name=&idcard=&email=' (length=58)

//array (size=6)
//  'telphone' => string '111111' (length=6)
//  'password' => string '' (length=0)
//  'c_password' => string '' (length=0)
//  'name' => string '' (length=0)
//  'idcard' => string '' (length=0)
//  'email' => string '' (length=0)
