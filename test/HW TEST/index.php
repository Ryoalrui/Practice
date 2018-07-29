<!-- 首页 -->
<?php
header('content-type:text/html;charset=UTF-8');
session_start();
$mysqli = new mysqli('localhost', 'root', '1010LING', 'hw');
$mysqli->query('set names utf8');
$res = $mysqli->query("SELECT * FROM m_system");
$rowset = $res->fetch_all(MYSQLI_ASSOC);
error_reporting('E_ALL&~E_NOTICE');
?>


<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>用户转账</title>
    <link href="style/css/bootstrap.min.css" rel="stylesheet">
    <link href="style/css/site.min.css" rel="stylesheet">
    <style>
        .container  .row .col-lg-4 img{ display: block; margin-left: auto; margin-right: auto; }
        .container .row .col-lg-4 h3,p{ text-align: center; }
        .row .col-lg-4 .button{ width: 360px; margin-left: 150px; margin-bottom: 10px;}
    </style>
</head>

<?php if ($_GET['username']=='') {
    ?>

<body>
    <!--导航栏-->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand hidden-sm" href="index.php">转转网</a>
            </div>
            <?php
            if ($_SESSION['name']!=null) {
                ?>
            <div class="navbar-header">
                <a class="navbar-brand hidden-sm"><?php echo $_SESSION['name']?>,欢迎您！</a>
            </div>
            <?php
            } ?>
        </div>
    </div>
    <!--导航栏结束-->
    <!--巨幕-->
    <div class="jumbotron masthead">
        <div class="container">
          <h1>学生转账管理系统</h1>
          <h2>实现学生转账功能</h2>
            <p class="masthead-button-links">
                <form class="form-inline" action="register.class.php" method="get">
                    <div class="form-group">
                      <?php if ($_SESSION['name']!=null) {
                ?>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="输入搜索内容" name="key" value="">
                        <button class="btn btn-default" type="submit">搜索</button>
                      <?php
            } ?>
                        <?php if ($_SESSION['name']==null) {
                ?>
                        <a href="register.php?res=1"><button type="button" class="btn btn-primary btn-default" data-toggle="modal">  注册  </button></a>
                        <a href="register.php?res=2"><button type="button" class="btn btn-primary btn-default" data-toggle="modal">  登录  </button></a>
                        <?php
            } else {
                ?>
                        <a href="out.class.php"><button type="button" class="btn btn-primary btn-default" data-toggle="modal">  退出  </button></a>
                        <?php
            } ?>
                    </div>
                </form>
            </p>
        </div>
    </div>
    <!--巨幕结束-->
    <!-- 模态框 -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form class="form-inline" action="transfer.class.php" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">转账</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                          收款人：

                          <select class="form-control" name="receiver">
                            <?php foreach ($rowset as $rows) {
                ?>
                              <?php  if ($rows['name']!=$_SESSION['name']) {
                    ?>
                            <option id="op" value=""><?php echo $rows['name']; ?></option>
                              <?php
                } ?>
                            <?php
            } ?>
                          </select>

                        </p>
                        <br />
                        <p>转账金额：<input type="text" class="form-control" id="exampleInputEmail1" placeholder="请输入数字"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="submit" id="submit" onclick="show(this)">确认转账</button>
                        <button type="reset" class="btn btn-default">重置</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--模态框结束-->
    <div class="container projects">
        <div class="projects-header page-header">
            <h2>用户列表</h2>
            <p>此页将显示已注册的用户信息</p>
        </div>
        <!--信息展示-->
        <div class="row">
          <?php
          foreach ($rowset as $rows) {
              ?>
            <div class="col-lg-4">
                <img class="img-circle" src="<?php echo str_ireplace('/', '\\', $rows['face']); ?>" alt="" width="140" height="140">
                <h3><?php echo $rows['name']?></h3>
                <p><?php echo $rows['info']?></p>
                <?php if ($_SESSION['name']!=null) {
                  ?>
                  <?php if ($_SESSION['name']!=$rows['name']) {
                      ?>
                <div class="button">
                  <button type="button" class="btn btn-primary btn-default" data-toggle="modal" data-target="#myModal" onclick="set()">  转账  </button>
                </div>
                <?php
                  } ?>
              <?php
              } ?>
            </div>
          <?php
          } ?>
        </div>
    </div>

    <script>
    function set(){
      var money = document.getElementById('exampleInputEmail1').value;
      // document.getElementById('op').value = money;
      alert(money);
    </script>

    <footer class="footer  container">
        <div class="row footer-bottom">
            <ul class="list-inline text-center">
                <h4><a href="index.php" target="_blank">yun.mooc.com</a> | 转转网</h4>
            </ul>
        </div>
    </footer>
    <script src="style/js/jquery.min.js"></script>
    <script src="style/js/bootstrap.min.js"></script>
</body>
<?php
} else {
              ?>
  <body>
      <!--导航栏-->
      <div class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
              <div class="navbar-header">
                  <a class="navbar-brand hidden-sm" href="index.php">转转网</a>
              </div>
              <?php
              if ($_SESSION['name']!=null) {
                  ?>
              <div class="navbar-header">
                  <a class="navbar-brand hidden-sm"><?php echo $_SESSION['name']?>,欢迎您！</a>
              </div>
              <?php
              } ?>
          </div>
      </div>
      <!--导航栏结束-->
      <!--巨幕-->
      <div class="jumbotron masthead">
          <div class="container">
            <h1>学生转账管理系统</h1>
            <h2>实现学生转账功能</h2>
              <p class="masthead-button-links">
                  <form class="form-inline" action="register.class.php" method="get">
                      <div class="form-group">
                        <?php if ($_SESSION['name']!=null) {
                  ?>
                          <input type="text" class="form-control" id="exampleInputName2" placeholder="输入搜索内容" name="key" value="">
                          <button class="btn btn-default" type="submit">搜索</button>
                        <?php
              } ?>
                          <?php if ($_SESSION['name']==null) {
                  ?>
                          <a href="register.php?res=1"><button type="button" class="btn btn-primary btn-default" data-toggle="modal">  注册  </button></a>
                          <a href="register.php?res=2"><button type="button" class="btn btn-primary btn-default" data-toggle="modal">  登录  </button></a>
                          <?php
              } else {
                  ?>
                          <a href="out.class.php"><button type="button" class="btn btn-primary btn-default" data-toggle="modal">  退出  </button></a>
                          <?php
              } ?>
                      </div>
                  </form>
              </p>
          </div>
      </div>
      <!--巨幕结束-->
      <!-- 模态框 -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
              <form class="form-inline" action="" method="post" enctype="multipart/form-data">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="myModalLabel">转账</h4>
                      </div>
                      <div class="modal-body">
                          <p>
                            收款人：

                            <select class="form-control" name="receiver">
                              <?php foreach ($rowset as $rows) {
                  ?>
                                <?php  if ($rows['name']!=$_SESSION['name']) {
                      ?>
                              <option value="<?php echo $rows['id']; ?>"><?php echo $rows['name']; ?></option>
                                <?php
                  } ?>
                              <?php
              } ?>
                            </select>

                          </p>
                          <br />
                          <p>转账金额：<input type="text" class="form-control" id="exampleInputEmail1" placeholder="请输入数字"></p>
                      </div>
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-primary" name="submit" id="submit" onclick="show(this)">确认转账</button>
                          <button type="reset" class="btn btn-default">重置</button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
      <!--模态框结束-->
      <div class="container projects">
          <div class="projects-header page-header">
              <h2>用户列表</h2>
              <p>此页将显示已注册的用户信息</p>
          </div>
          <!--信息展示-->
          <div class="row">
              <div class="col-lg-4">
                  <img class="img-circle" src="<?php echo str_ireplace('/', '\\', $_GET['face']); ?>" alt="" width="140" height="140">
                  <h3><?php echo $_GET['username']; ?></h3>
                  <p><?php echo $_GET['info']; ?></p>
                  <?php if ($_SESSION['name']!=null) {
                  ?>
                    <?php if ($_SESSION['name']!=$rows['name']) {
                      ?>
                  <div class="button">
                    <button type="button" class="btn btn-primary btn-default" data-toggle="modal" data-target="#myModal" onclick="set(<?php echo $rows['id']; ?>)">  转账  </button>
                  </div>
                  <?php
                  } ?>
                <?php
              } ?>
              </div>
          </div>
      </div>
      <footer class="footer  container">
          <div class="row footer-bottom">
              <ul class="list-inline text-center">
                  <h4><a href="index.php" target="_blank">yun.mooc.com</a> | 转转网</h4>
              </ul>
          </div>
      </footer>
      <script src="style/js/jquery.min.js"></script>
      <script src="style/js/bootstrap.min.js"></script>
  </body>
  <?php
          } ?>
</html>
