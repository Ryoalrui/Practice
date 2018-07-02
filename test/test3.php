$arr = ['apple','banana','orange'];
$narr1 = json_encode($arr);//进行json编码，返回字符串，包含了 value 值 JSON 形式的表示。

$narr2 = json_decode($narr1);//进行json解码还原
echo $narr1.'<br/>'.$narr2;
