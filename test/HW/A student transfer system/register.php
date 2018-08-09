<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>注册|登录界面</title>
    <link href="style/css/bootstrap.min.css" rel="stylesheet">
    <link href="style/css/site.min.css" rel="stylesheet">
</head>

<body>
    <!--导航栏-->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand hidden-sm" href="index.php">转转网</a>
            </div>
        </div>
    </div>
    <!--导航栏结束-->
  <?php if ($_GET['jump']=='register'):?>
    <!-- 注册页面 -->
    <div class="container projects">
        <div class="projects-header page-header">
            <h3>注册</h3>
            <a href="register.php?jump=login"><button type="submit" class="btn btn-primary btn-default">去登录</button></a>
        </div>
        <!--注册框-->
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <form class="form-horizontal" action="register.class.php" method="post" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">姓名</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" name="rname" placeholder="请输入姓名，字数不超过5位">
                  </div>
              </div>
              <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">学号</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" name="rnumber" placeholder="请输入学号，字数不超过10位" maxlength="10">
                  </div>
              </div>
              <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">邮箱</label>
                  <div class="col-sm-10">
                      <input type="email" class="form-control" name="email" placeholder="请输入正确邮箱">
                  </div>
              </div>
              <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">金钱</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" name="money" placeholder="请输入数字">
                  </div>
              </div>
              <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">头像</label>
                  <div class="col-sm-10">
                      <input type="file" name="face">
                  </div>
              </div>
              <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">个人简介</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" rows="2"  name="info" placeholder="不超过50字">24K纯帅~</textarea>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary btn-default">提交</button>
                      <button type="submit" class="btn btn-default">重置</button>
                  </div>
              </div>
              </form>
          </div>
        </div>

        <!--登录框-->
      <?php elseif ($_GET['jump']=='login'):?>
        <!-- 登录页面 -->
        <div class="projects-header page-header">
            <h3>登录</h3>
            <a href="register.php?jump=register"><button type="submit" class="btn btn-primary btn-default">去注册</button></a>
        </div>
        <!-- 登录框 -->
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form class="form-horizontal" action="register.class.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">姓名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="请输入姓名" name="lname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">学号</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="请输入学号" name="lnumber" maxlength="10">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary btn-default">提交</button>
                            <button type="reset" class="btn btn-default">重置</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  <?php endif;?>
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

</html>
