<?php
header('content-type:text/html;charset=UTF-8');
//连接数据库，设置字符集，查询数据库内的相关信息，将其显示在前端页面
$mysqli = new mysqli('localhost', 'root', '1010LING', 'hw');
$mysqli->query('set names utf8');
$data = $mysqli->query('SELECT info,addr FROM pic_upload_system');
$res = array_reverse($data->fetch_all(MYSQLI_ASSOC));//数据信息进行倒序摆放
?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>文件上传和下载</title>
    <!-- Bootstrap -->
    <link href="style/css/bootstrap.min.css" rel="stylesheet">
    <link href="style/css/site.min.css" rel="stylesheet">
    <style>
        .projects .thumbnail .caption {
            height: auto;
            max-width: auto;
        }
        .image{
            margin:10px auto;
            border-radius:5px;
            overflow:hidden;
            border:1px solid #CCC;
        }
        .image .caption P{
            text-align: center;
        }
    </style>
</head>

<?php if ($_GET['search']==''): ?>
<body>
    <!--导航栏-->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand hidden-sm" href="" onclick="_hmt.push(['_trackEvent', 'navbar', 'click', 'navbar-首页'])">酷图</a>
            </div>
            <div class="navbar-collapse collapse" role="navigation">
                <ul class="nav navbar-nav">
                    <li class="hidden-sm hidden-md">
                        <a href="" target="_blank"></a>
                    </li>
                    <li>
                        <a href="" target="_blank"></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--导航栏结束-->
    <!--巨幕-->
    <div class="jumbotron masthead">
        <div class="container">
            <h1>文件上传下载</h1>
            <h2>实现文件的上传和下载功能</h2>
            <p class="masthead-button-links">
                <form class="form-inline" action="search.php" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="输入关键字搜索相关图片" name="key">
                        <button class="btn btn-default" type="submit">搜索</button>
                        <button type="button" class="btn btn-primary btn-default" data-toggle="modal" data-target="#myModal">  上传  </button>
                    </div>
                </form>
            </p>
        </div>
    </div>
    <!--巨幕结束-->
    <!-- 模态框 -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form class="form-inline" action="handle.php" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">上传图片</h4>
                    </div>
                    <div class="modal-body">
                        <p>选择图片：</p><input type="file" name="upload">
                        <br/>
                        <p>图片描述：</p><textarea class="form-control" cols="75" name="info" id="info"></textarea>
                        <br/><br/>
                        <p>
                          是否添加水印：
                          <select name="mark">
                            <option value="1">添加</option>
                            <option value="0">不添加</option>
                          </select>
                        </p>
                        <br/>
                        <p>
                          图片宽度比例：
                            <select name="scale">
                              <option value="800*600">800*600</option>
                              <option value="600*450">600*450</option>
                              <option value="400*300">400*300</option>
                            </select>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default" name="submit" id="submit" onclick="show(this)">上传</button>
                        <button type="reset" class="btn btn-primary">重置</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--模态框结束-->

    <div class="container projects">
        <div class="projects-header page-header">
            <h2>上传图片展示</h2>
            <p>将上传的图片展示在页面中</p>
        </div>
        <div class="row">
          <?php foreach ($res as $single): ?>
            <div class="col-sm-6 col-md-3 col-lg-4 ">
                <div class="image">
                    <img class="img-responsive" src="<?php echo strstr($single['addr'], 'u');?>">
                    <div class="caption">
                      <p><?php echo $single['info']; ?></p>
                    </div>
                </div>
            </div>
          <?php endforeach; ?>
        </div>
        <!--分页-->
        <nav aria-label="Page navigation" style="text-align:center">
            <ul class="pagination pagination-lg">
                <li>
                    <a href="" aria-label="Previous">
                        <span aria-hidden="true">首页</span>
                    </a>
                </li>
                <li><a href="">1</a></li>
                <li><a href="">2</a></li>
                <li><a href="">3</a></li>
                <li><a href="">4</a></li>
                <li><a href="">5</a></li>
                <li>
                    <a href="" aria-label="Next">
                        <span aria-hidden="true">尾页</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <footer class="footer  container">
        <div class="row footer-bottom">
            <ul class="list-inline text-center">
                <h4>best pic.com | 酷图</h4>
            </ul>
        </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="style/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="style/js/bootstrap.min.js"></script>
    <script type="text/JavaScript">
        function show(){
          if(document.getElementById("info").value == ''){
            alert('请输入图片描述');
          }
        }
    </script>
</body>

<?php else: ?>

<body>
    <!--导航栏-->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand hidden-sm" href="" onclick="_hmt.push(['_trackEvent', 'navbar', 'click', 'navbar-首页'])">酷图</a>
            </div>
            <div class="navbar-collapse collapse" role="navigation">
                <ul class="nav navbar-nav">
                    <li class="hidden-sm hidden-md">
                        <a href="" target="_blank"></a>
                    </li>
                    <li>
                        <a href="" target="_blank"></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--导航栏结束-->
    <!--巨幕-->
    <div class="jumbotron masthead">
        <div class="container">
            <h1>文件上传下载</h1>
            <h2>实现文件的上传和下载功能</h2>
            <p class="masthead-button-links">
                <form class="form-inline" action="search.php" method="get">
                    <div class="form-group">
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="输入关键字搜索相关图片" name="key">
                        <button class="btn btn-default" type="submit">搜索</button>
                        <button type="button" class="btn btn-primary btn-default" data-toggle="modal" data-target="#myModal">  上传  </button>
                    </div>
                </form>
            </p>
        </div>
    </div>
    <!--巨幕结束-->
    <!-- 模态框 -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form class="form-inline" action="handle.php" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">上传图片</h4>
                    </div>
                    <div class="modal-body">
                        <p>选择图片：</p><input type="file" name="upload">
                        <br/>
                        <p>图片描述：</p><textarea class="form-control" cols="75" name="info" id="info"></textarea>
                        <br/><br/>
                        <p>
                          是否添加水印：
                          <select name="mark">
                            <option value="1">添加</option>
                            <option value="0">不添加</option>
                          </select>
                        </p>
                        <br/>
                        <p>
                          图片宽度比例：
                            <select name="scale">
                              <option value="800*600">800*600</option>
                              <option value="600*450">600*450</option>
                              <option value="400*300">400*300</option>
                            </select>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default" name="submit" id="submit" onclick="show(this)">上传</button>
                        <button type="reset" class="btn btn-primary">重置</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--模态框结束-->

    <div class="container projects">
        <div class="projects-header page-header">
            <h2>上传图片展示</h2>
            <p>将上传的图片展示在页面中</p>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-3 col-lg-4 ">
                <div class="image">
                    <img class="img-responsive" src="<?php echo strstr($_GET['addr'], 'u');?>">
                    <div class="caption">
                      <p><?php echo $_GET['search']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <!--分页-->
        <nav aria-label="Page navigation" style="text-align:center">
            <ul class="pagination pagination-lg">
                <li>
                    <a href="" aria-label="Previous">
                        <span aria-hidden="true">首页</span>
                    </a>
                </li>
                <li><a href="">1</a></li>
                <li><a href="">2</a></li>
                <li><a href="">3</a></li>
                <li><a href="">4</a></li>
                <li><a href="">5</a></li>
                <li>
                    <a href="" aria-label="Next">
                        <span aria-hidden="true">尾页</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <footer class="footer  container">
        <div class="row footer-bottom">
            <ul class="list-inline text-center">
                <h4>best pic.com | 酷图</h4>
            </ul>
        </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="style/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="style/js/bootstrap.min.js"></script>
    <script type="text/JavaScript">
        function show(){
          if(document.getElementById("info").value == ''){
            alert('请输入图片描述');
          }
        }
    </script>
</body>
<?php endif; ?>

</html>
