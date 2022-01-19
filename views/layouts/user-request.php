<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\web\Cookie;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="http://monkeywebstudio.com/">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<i class="glyphicon glyphicon-hdd"></i> '.Yii::t('app','system_name'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    //user
    $menu = [
        ['label' => '<i class="glyphicon glyphicon-tasks"></i> '.Yii::t('app','job_order'), 'url' => ['/user-request/index']],
        ['label' => '<i class="glyphicon glyphicon-user"></i> User (' . Yii::$app->user->identity->user_fullname . ')',
            'items' => [
                ['label' => '<i class="glyphicon glyphicon-pencil"></i> '.Yii::t('app','edit_profile'),  'url' => ['user-request/edit-profile']],
                ['label' => '<i class="glyphicon glyphicon-off"></i> '.Yii::t('app','logout'),
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post','data-confirm'=>Yii::t('app','confirm_logout')]
                ],
            ],
        ],
    ];


    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menu,
        'encodeLabels'=>false,
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">

      <?php
        $lang =  Yii::$app->request->cookies['language'];

		if(!empty($lang)){

			echo Html::a($lang->value == 'en' ? '<i class="glyphicon glyphicon-globe"></i>  English' : '<i class="glyphicon glyphicon-globe"></i>  ภาษาไทย',['site/lang','language' => $lang->value == 'en' ? 'th' : 'en']);
		}else{
			echo Html::a('<i class="glyphicon glyphicon-globe"></i>  ภาษาไทย',['site/lang','language' => 'en']);
		}
      ?>

        <div class="pull-right">
            	<i class="glyphicon glyphicon-hdd"></i> <?=Yii::t('app','system_name')?> <small><?= $this->render('version')?></small>
        </div>

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
