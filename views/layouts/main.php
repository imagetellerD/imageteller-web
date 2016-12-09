<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <div class="container">
        <?= $content ?>
    </div>
</div>

<footer class="footer">
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<style>
.wrap {
	background-image: url('/css/analyze_image/base.png');
    background-repeat: no-repeat;
    background-size: cover;
    min-height: 800px;
    background-position: center;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
	padding: initial;
}
.container {
	height:100%;
    min-height: 800px;
	/*overflow: hidden;*/
}
/*
.container {
	height:100%;
	background-image: url('/css/analyze_image/main_all.png');
	background-size: 100%;
    background-repeat: no-repeat;
    background-size: cover;
    min-height: 800px;
	
}
*/
</style>
