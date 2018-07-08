<?php
header('content-type:text/html;charset=UTF-8');
//实例化pdo
$pdo=new pdo('mysql:host=localhost;dbname=mydb', '用户名', '用户密码');
$pdo->exec('set names utf8');

$arr=$pdo->query("SELECT type_name,type_id FROM tdb_goods_types LIMIT 0,1");
$data=$arr->fetchAll(PDO::FETCH_ASSOC);
// echo '<pre>';
// print_r($data);
// echo '</pre>';
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=UTF-8">
  <!-- 加载jquery.js -->
  <script src='http://cdn.bootcss.com/jquery/3.1.1/jquery.min.js'></script>
  <title>Ajax实战-实现类似加载更多的效果</title>
  <style>
    td{
      text-align:center;
      width:100px;
      }
  </style>
</head>
<body>
  <div style="width:6%;margin:auto;"><button id="bid">加载更多</button></div>
  <br/>
  <table align='center' border='1' cellspacing='1'>
    <tr>
      <th>名字</th>
      <th>地点</th>
    </tr>
    <?php
      foreach ($data as $key=>$val) {
          echo '<tr>';
          echo '<td>'.$val['type_name'].'</td><td>'.$val['type_id'].'</td>';
          echo '</tr>';
      }
    ?>
  </table>

  <script>
  //1.触发事件
    $('#bid').click(function(){
      var num=  $('tr').length - 1;//利用jQuery写法，测量已显示的数据量

  //2.发起ajax请求
      $.post('10backstage.php',{number:num},function(data){
        // 如果状态码是正常情况（200）
        if(data.code==200)
        {
          //正常返回数据
          $('table').append(data.msg);
        }
        if(data.code==300)
        {
          alert(data.msg);
          $('#bid').remove();
        }
        if(data.code==400)
        {
          alert(data.msg);
        }
    },'json');
   });

  </script>
</body>
</html>
