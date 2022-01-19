<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\System;
use yii\web\Cookie;

$login = System::findOne(1);

$login_required = $login->login_required;

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

    if(Yii::$app->user->isGuest){

        $menu = [
             ['label' => '<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app','job_order'), 'url' => ['/request/index'],'visible' => $login_required == true ? false : true],
             //['label' => '<i class="glyphicon glyphicon-user"></i> '.Yii::t('app','register'), 'url' => ['/site/register'],'visible' => $login_required == true ? true : false],
             ['label' => '<i class="glyphicon glyphicon-lock"></i> '.Yii::t('app','login'), 'url' => ['/site/login']],
        ];

    }else{
        //admin
        if(Yii::$app->user->identity->role == 'admin'){
            $menu = [
                ['label' => '<i class="glyphicon glyphicon-tasks"></i> '.Yii::t('app','work_information'), 'url' => ['/job/index'],'options'=>['id'=>'job']],
                ['label' => '<i class="glyphicon glyphicon-list-alt"></i> '.Yii::t('app','device_register'), 'url' => ['/device/index'],'options'=>['id'=>'device']],
                ['label' => '<i class="glyphicon glyphicon-file"></i> '.Yii::t('app','report'), 'url' => ['/report/index'],'options'=>['id'=>'report']],
                ['label' => '<i class="glyphicon glyphicon-cog"></i> '.Yii::t('app','system_setting'),
                    'items' => [
                        ['label' => '<i class="glyphicon glyphicon-flag"></i> '.Yii::t('app','device_type_setting'), 'url' => ['/device-type/index']],
                        ['label' => '<i class="glyphicon glyphicon-wrench"></i> '.Yii::t('app','job_type_setting'), 'url' => ['/job-type/index']],
                        ['label' => '<i class="glyphicon glyphicon-wrench"></i> '.Yii::t('app','software_setting'), 'url' => ['/software-detail/index']],
                        ['label' => '<i class="glyphicon glyphicon-map-marker"></i> '.Yii::t('app','department_setting'), 'url' => ['/department/index']],
                        ['label' => '<i class="glyphicon glyphicon-user"></i> '.Yii::t('app','employee_setting'), 'url' => ['/employee/index']],
                        ['label' => '<i class="glyphicon glyphicon-lock"></i> '.Yii::t('app','admin_setting'), 'url' => ['/user/index']],
						            ['label' => '<i class="glyphicon glyphicon-import"></i> '.Yii::t('app','import_setting'), 'url' => ['/import/index']],
						            ['label' => '<i class="glyphicon glyphicon-download"></i> '.Yii::t('app','backup_setting'), 'url' => ['/default/index']],
                    ],
					          'options'=>['id'=>'setting'],
                ],
                ['label' => '<i class="glyphicon glyphicon-user"></i> Admin (' . Yii::$app->user->identity->fullname . ')',

                    'items' => [
                      ['label' => '<i class="glyphicon glyphicon-pencil"></i> '.Yii::t('app','edit_profile'), 'url' => ['/user/edit-profile']],
                        ['label' => '<i class="glyphicon glyphicon-off"></i> '.Yii::t('app','logout'), 'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post','data-confirm'=>Yii::t('app','confirm_logout')],
                        ],

                    ],
                ],
            ];

          }else if(Yii::$app->user->identity->role == 'support'){

                $menu = [
                    ['label' => '<i class="glyphicon glyphicon-tasks"></i> '.Yii::t('app','work_information'), 'url' => ['/job/index']],
                    ['label' => '<i class="glyphicon glyphicon-list-alt"></i> '.Yii::t('app','device_register'), 'url' => ['/device/index']],
                    //['label' => '<i class="glyphicon glyphicon-file"></i> '.Yii::t('app','report'), 'url' => ['/report/index']],
                    ['label' => '<i class="glyphicon glyphicon-user"></i> Support (' . Yii::$app->user->identity->fullname . ')',
                    'items' => [
                      ['label' => '<i class="glyphicon glyphicon-pencil"></i> '.Yii::t('app','edit_profile'), 'url' => ['/user/edit-profile']],
                        ['label' => '<i class="glyphicon glyphicon-off"></i> '.Yii::t('app','logout'), 'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post','data-confirm'=>Yii::t('app','confirm_logout')],
                        ],

                    ],
                    ],

                ];
          }else{

			    $menu = [
					['label' => '<i class="glyphicon glyphicon-user"></i>',
                    'items' => [
                        ['label' => '<i class="glyphicon glyphicon-off"></i> '.Yii::t('app','logout'), 'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post','data-confirm'=>Yii::t('app','confirm_logout')],
                        ],
                    ],
                   ],
                ];
		  }
    }


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

			echo Html::a($lang->value == 'en' ? '<i class="glyphicon glyphicon-globe"></i>  English' : '<i class="glyphicon glyphicon-globe"></i>  ภาษาไทย',
			[
				'site/lang','language' => $lang->value == 'en' ? 'th' : 'en',
			]);

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
