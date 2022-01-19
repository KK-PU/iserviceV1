<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\models\UserSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\growl\Growl;
/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var UserSearch $searchModel
 */

$this->title = Yii::t('user', 'ตั้งค่าบัญชีผู้ใช้ระบบ');

//$this->params['breadcrumbs'][] = $this->title;
if(Yii::$app->session->hasFlash('save')):
    echo Growl::widget([
        'type' => Growl::TYPE_SUCCESS,
        'icon' => 'glyphicon glyphicon-ok-sign',
        'title' => 'สำเร็จ',
        'showSeparator' => true,
        'body' => 'บันทึกข้อมูลผู้ใช้งานระบบเรียบร้อยแล้ว'
    ]);
endif;

if(Yii::$app->session->hasFlash('delete')):
    echo Growl::widget([
        'type' => Growl::TYPE_DANGER,
        'icon' => 'glyphicon glyphicon-ok-sign',
        'title' => 'สำเร็จ',
        'showSeparator' => true,
        'body' => 'ลบข้อมูลผู้ใช้งานระบบเรียบร้อยแล้ว'
    ]);
endif;
?>

<?= $this->render('/_alert', [
    'module' => Yii::$app->getModule('user'),
]) ?>

 <h4><?= Html::encode($this->title) ?></h4>
<hr>
<?php // $this->render('/admin/_menu') ?>
    <p>
        <?= Html::a('เพิ่มผู้ใช้งานระบบ',['/user/admin/create'],['class'=>'btn btn-success'])?>
    </p>
<?php Pjax::begin() ?>

<?= GridView::widget([
    'dataProvider' 	=> $dataProvider,
    //'filterModel'  	=> $searchModel,
    'layout'  		=> "{items}\n{pager}",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
		[
            'attribute' => 'username',
            'options' => ['style' => 'width:15%'],
        ],
        [
            'attribute' => 'fullname',
            'options' => ['style' => 'width:20%'],
        ],
        [
            'attribute' => 'position',
            'options' => ['style' => 'width:20%'],
        ],
        [
            'attribute' => 'email',
            'options' => ['style' => 'width:20%'],
        ],

		[
            'attribute' => 'role',
            'options' => ['style' => 'width:10%'],
			'value'=>function($model){
				return ($model->role == 1 ) ? 'IT System Admin' : 'IT User';
			}
        ],
        //'email:email',
        /*[
            'attribute' => 'registration_ip',
            'value' => function ($model) {
                return $model->registration_ip == null
                    ? '<span class="not-set">' . Yii::t('user', '(not set)') . '</span>'
                    : $model->registration_ip;
            },
            'format' => 'html',
        ],
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                if (extension_loaded('intl')) {
                    return Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]);
                } else {
                    return date('Y-m-d G:i:s', $model->created_at);
                }
            },
            'filter' => DatePicker::widget([
                'model'      => $searchModel,
                'attribute'  => 'created_at',
                'dateFormat' => 'php:Y-m-d',
                'options' => [
                    'class' => 'form-control',
                ],
            ]),
        ],
        [
            'header' => Yii::t('user', 'Confirmation'),
            'value' => function ($model) {
                if ($model->isConfirmed) {
                    return '<div class="text-center"><span class="text-success">' . Yii::t('user', 'Confirmed') . '</span></div>';
                } else {
                    return Html::a(Yii::t('user', 'Confirm'), ['confirm', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-success btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
                    ]);
                }
            },
            'format' => 'raw',
            'visible' => Yii::$app->getModule('user')->enableConfirmation,
        ],
        [
            'header' => Yii::t('user', 'Block status'),
            'value' => function ($model) {
                if ($model->isBlocked) {
                    return Html::a(Yii::t('user', 'Unblock'), ['block', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-success btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                    ]);
                } else {
                    return Html::a(Yii::t('user', 'Block'), ['block', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-danger btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?'),
                    ]);
                }
            },
            'format' => 'raw',
        ],*/
		
		[
			'header'=>'แก้ไข/ลบ',
			'class' => 'yii\grid\ActionColumn',
			'options' => ['style' => 'width:10%;'],
			'template' => '{update} {delete}',
			'buttons' => [
				'update' => function($url, $model, $key) {

					return Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['update','id'=>$model->id], ['class' => 'btn btn-warning btn-xs']);
				},
						
				'delete' => function($url, $model, $key) {

					return Html::a('<i class="glyphicon glyphicon-trash"></i>',  ['delete','id'=>$model->id], [
								'title' => Yii::t('yii', 'Delete'),
								'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
								'data-method' => 'post',
								'data-pjax' => '0',
								'class' => 'btn btn-danger btn-xs'
					]);
				}
			]
		],
		
    ],
]); ?>

<?php Pjax::end() ?>
<?php
$this->registerJs("
	$(function(){
		$('#setting').addClass('active');
	});
");
?>
