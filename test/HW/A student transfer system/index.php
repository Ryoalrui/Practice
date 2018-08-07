<?php
//假设：上线项目关闭错误报告
ini_set('display_errors', 0);
//开启会话
session_start();
//连接数据库，设置字符集，从数据库查找出用户的id,姓名，简介和头像
$mysqli = new mysqli('localhost', 'root', '你的密码', '你的数据库');
$mysqli->query('set names utf8');
$data = $mysqli->query('SELECT id,name,info,face FROM 你的数据表');
$res = $data->fetch_all(MYSQLI_ASSOC);
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

<?php if ($_GET['username']==''): ?>
<!-- 展示用户界面 -->
<body>
    <!--导航栏-->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand hidden-sm" href="index.php">转转网</a>
            </div>
          <?php if ($_SESSION['name']!=null): ?>
            <div class="navbar-header">
                <a class="navbar-brand hidden-sm"><?php echo $_SESSION['name']?>,欢迎您！</a>
            </div>
          <?php endif; ?>
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
                      <?php if ($_SESSION['name']!=null) :?>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="输入搜索内容" name="key" value="">
                        <button class="btn btn-default" type="submit">搜索</button>
                      <?php endif; ?>
                      <?php if ($_SESSION['name']==null) :?>
                        <a href="register.php?jump=register"><button type="button" class="btn btn-primary btn-default" data-toggle="modal">  注册  </button></a>
                        <a href="register.php?jump=login"><button type="button" class="btn btn-primary btn-default" data-toggle="modal">  登录  </button></a>
                      <?php endif; ?>
                      <?php if ($_SESSION['name']!=null): ?>
                        <a href="out.class.php"><button type="button" class="btn btn-primary btn-default" data-toggle="modal">  退出  </button></a>
                      <?php endif; ?>
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
                        <h4 class="modal-title" id="myModalLabel" onclick="set('默认的学生ID值')">转账</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                          收款人：
                          <select class="form-control" name="Payee">
                           <?php foreach ($res as $user): ?>
                            <?php if ($user['name']!=$_SESSION['name']): ?>
                            <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
                            <?php endif; ?>
                          <?php endforeach; ?>
                          </select>
                        </p>
                        <br />
                        <p>转账金额：<input type="text" class="form-control" name="Amount" id="exampleInputEmail1" placeholder="请输入数字"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submit" onclick="show(this)">确认转账</button>
                        <button type="reset" class="btn btn-default">重置</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--模态框结束-->
    <div class="container projects">
        <div class="projects-header page-header">
            <h2>用户展示</h2>
            <p>将用户信息展示在页面中</p>
        </div>
        <!--信息展示-->
         <div class="row">
           <?php foreach ($res as $user): ?>
            <div class="col-lg-4">
                <img class="img-circle" src="<?php echo strstr($user['face'], 'u');?>" alt="用户头像" width="140" height="140">
                <h3><?php echo $user['name']; ?></h3>
                <p><?php echo $user['info']; ?></p>
              <?php if ($_SESSION['name']!=null): ?>
               <?php if ($_SESSION['name']!=$user['name']): ?>
                <div class="button">
                  <button type="button" class="btn btn-primary btn-default" data-toggle="modal" data-target="#myModal">  转账  </button>
                </div>
               <?php endif; ?>
              <?php endif; ?>
            </div>
            <?php endforeach; ?>
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



<?php else: ?>



<!-- 展示搜索界面 -->
<body>
    <!--导航栏-->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand hidden-sm" href="index.php">转转网</a>
            </div>
          <?php if ($_SESSION['name']!=null): ?>
            <div class="navbar-header">
                <a class="navbar-brand hidden-sm"><?php echo $_SESSION['name']?>,欢迎您！</a>
            </div>
          <?php endif; ?>
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
                      <?php if ($_SESSION['name']!=null) :?>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="输入搜索内容" name="key" value="">
                        <button class="btn btn-default" type="submit">搜索</button>
                      <?php endif; ?>
                      <?php if ($_SESSION['name']==null) :?>
                        <a href="register.php?jump=register"><button type="button" class="btn btn-primary btn-default" data-toggle="modal">  注册  </button></a>
                        <a href="register.php?jump=login"><button type="button" class="btn btn-primary btn-default" data-toggle="modal">  登录  </button></a>
                      <?php endif; ?>
                      <?php if ($_SESSION['name']!=null): ?>
                        <a href="out.class.php"><button type="button" class="btn btn-primary btn-default" data-toggle="modal">  退出  </button></a>
                      <?php endif; ?>
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
                          <select class="form-control">
                            <option value="">user1</option>
                            <option value="">user2</option>
                            <option value="">user3</option>
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
            <h2>搜索用户</h2>
            <p>将搜索的用户展示在页面中</p>
        </div>
        <!--信息展示-->
         <div class="row">
            <div class="col-lg-4">
                <img class="img-circle" src="<?php echo strstr($_GET['face'], 'u');?>" alt="用户头像" width="140" height="140">
                <h3><?php echo $_GET['username']; ?></h3>
                <p><?php echo $_GET['info']; ?></p>
              <?php if ($_SESSION['name']!=null): ?>
               <?php if ($_SESSION['name']!=$_GET['username']): ?>
                <div class="button">
                  <button type="button" class="btn btn-primary btn-default" data-toggle="modal" data-target="#myModal">  转账  </button>
                </div>
               <?php endif; ?>
              <?php endif; ?>
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
<?php endif; ?>

</html>
