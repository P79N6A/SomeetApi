<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Someet</title>
  <link rel="stylesheet" href="/layui/css/layui.css">
  <link rel="stylesheet" type="text/css" href="/css/site.css">
  <link rel="stylesheet" type="text/css" href="/layui/css/cropper.css">
  <script src="/layui/layui.all.js"></script>
</head>
<body>
    <input type="hidden" id='_csrf' value="<?= Yii::$app->request->csrfToken ?>" name="">
   <div class="layui-layout layui-layout-admin">
    <div class="layui-header header header-demo" spring>
        <div class="layui-main">
            <a class="logo" href="/">
                <img src="https://res.layui.com/static/images/layui/logo.png" alt="layui">
            </a>
            <div class="layui-form component" lay-filter="LAY-site-header-component"></div>
            <ul class="layui-nav">
                <li class="layui-nav-item ">
                    <a href="javascript:;">活动分类</a> 
                </li>
                <li class="layui-nav-item layui-this">
                    <a href="javascript:;">活动</a>
                </li>
                <li class="layui-nav-item layui-hide-xs">
                    <a href="//fly.layui.com/" target="_blank">活动审核</a>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;">联系人</a>
                    <dl class="layui-nav-child">
                        <dd lay-unselect>
                            <a href="//fly.layui.com/extend/" target="_blank">扩展组件</a>
                        </dd>
                        <dd lay-unselect>
                            <a href="//fly.layui.com/store/" target="_blank">模板市场 <span class="layui-badge-dot"></span>
                            </a>
                        </dd>
                    </dl>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;/">场地<span class="layui-badge-dot" style="margin-top: -5px;"></span></a>
                </li>
                <li class="layui-nav-item ">
                    <a href="javascript:;">DTS</a> 
                </li>
                <li class="layui-nav-item ">
                    <a href="javascript:;">举报</a> 
                </li>
            </ul>
        </div>
    </div>
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <ul class="layui-nav layui-nav-tree site-demo-nav">
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="javascript:;" href="javascript:;">系统设置</a>
                    <dl class="layui-nav-child">
                        <dd>
                            <a href="./demo.html">操作日志</a>
                        </dd>
                    </dl>
                </li>
                <li class="layui-nav-item" style="height: 30px; text-align: center"></li>
            </ul>
        </div>
    </div>
</div>
</body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
