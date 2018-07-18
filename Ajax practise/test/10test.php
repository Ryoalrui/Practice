<?php
header("content-type:text/html;charser=UTF-8");
// $val = $_GET['pos'];//get形式获取值
$val = $_POST['pos'];//post形式获取值

parse_str($val, $post);
$level = ['B','KB','MB','GB','TB'];
$key = floor(log($post['num'], 1024));
$res = round($post['num']/(pow(1024, $key)), 2).$level[$key];
echo json_encode(['transform'=>$res]);//单个数据就不要用json了
