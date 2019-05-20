<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
$controller = Yii::$app->controller->id;
$query = Yii::$app->request->getQueryParam('status')?Yii::$app->request->getQueryParam('status'):1;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Someet</title>
  <link rel="stylesheet" type="text/css" href="/layui/css/layui.css">
  <link rel="stylesheet" type="text/css" href="/css/site.css">
  <link rel="stylesheet" type="text/css" href="/layui/css/cropper.css">
  <script src="/layui/layui.all.js"></script>
</head>
<body>
    <input type="hidden" id='_csrf' value="<?= Yii::$app->request->csrfToken ?>" name="">
    <input type="hidden" id='access_token' value="<?php echo Yii::$app->session->get('access_token');?>">
   <div class="layui-layout layui-layout-admin">
    <div class="layui-header header header-demo" spring>
        <div class="layui-main">
            <a class="logo" href="/">
                <img src="/image/login/11.jpg" style="width: 37px;height: 37px;" alt="layui">
            </a>
            <div class="layui-form component" lay-filter="LAY-site-header-component"></div>
            <ul class="layui-nav">
                <li class="layui-nav-item">
                    <a href="javascript:;">活动分类</a> 
                    <dl class="layui-nav-child">
                      <dd><a href="/classify/index">一级分类</a></dd>
                      <dd><a href="/classify/sub-index">二级分类</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item <?php echo $controller == 'activity' && $query == 1?'layui-this':'';?>">
                    <a href="/activity/index?status=1">活动</a>
                </li>
                <li class="layui-nav-item layui-hide-xs <?php echo $controller == 'activity' && $query == 8?'layui-this':'';?>">
                    <a href="/activity/check?status=8">活动审核</a>
                </li>
                <li class="layui-nav-item <?php echo $controller == 'member'?'layui-this':'';?>">
                    <a href="/member/index?status=1">用户</a>
                </li>
                <li class="layui-nav-item layui-hide-xs <?php echo $controller == 'space'?'layui-this':'';?>" lay-unselect>
                    <a href="/space/index">场地<span class="layui-badge-dot" style="margin-top: -5px;"></span></a>
                </li>
                <li class="layui-nav-item <?php echo $controller == 'dts'?'layui-this':'';?>">
                    <a href="/dts/index">DTS</a> 
                </li>
                <li class="layui-nav-item <?php echo $controller == 'feedback'?'layui-this':'';?>">
                    <a href="/feedback/index">举报</a> 
                </li>
                <li class="layui-nav-item <?php echo $controller == 'chat'?'layui-this':'';?>">
                    <a href="/activity/msg" target="_blank">人工客服</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="layui-side layui-bg-black" style="width: 120px;">
        <div class="layui-side-scroll">
            <ul class="layui-nav layui-nav-tree site-demo-nav">
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="javascript:;" href="javascript:;">系统设置</a>
                    <dl class="layui-nav-child">
                        <dd>
                            <a href="javascript:;">操作日志</a>
                        </dd>
                        <dd>
                            <a href="/site/logout">退出登录</a>
                        </dd>
                    </dl>
                </li>
                <li class="layui-nav-item" style="height: 30px; text-align: center"></li>
            </ul>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    var element = layui.element
    element.render();
    var $ = layui.jquery
    var token = $('#access_token').val();
    if(!token){
        layer.open({
          content: '登录失效',
          yes: function(index, layero){
            //do something
            layer.close(index); //如果设定了yes回调，需进行手工关闭
            window.location.href = '/site/login';
          },
          cancel: function(index, layero){ 
              window.location.href = '/site/login';
            } 
        });        
     
        
    }
</script>
<?php $this->beginBody() ?>
<div class="container">
        <?= $content ?>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
