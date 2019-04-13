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
  <link rel="stylesheet" href="/layui/css/layui.css">
  <link rel="stylesheet" type="text/css" href="/css/site.css">
  <link rel="stylesheet" type="text/css" href="/layui/css/cropper.css">
  <script src="/layui/layui.all.js"></script>
</head>
<body>
    <input type="hidden" id='_csrf' value="<?= Yii::$app->request->csrfToken ?>" name="">
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
