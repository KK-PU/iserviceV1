<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\growl\Growl;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app','admin_setting');
//$this->params['breadcrumbs'][] = $this->title;
if(Yii::$app->session->hasFlash('save')):
    echo Growl::widget([
        'type' => Growl::TYPE_SUCCESS,
        'icon' => 'glyphicon glyphicon-ok-sign',
        'title' => Yii::t('app','success_status'),
        'showSeparator' => true,
        'body' => Yii::t('app','save_success_alert')
    ]);
endif;

if(Yii::$app->session->hasFlash('delete')):
    echo Growl::widget([
        'type' => Growl::TYPE_DANGER,
        'icon' => 'glyphicon glyphicon-ok-sign',
        'title' => Yii::t('app','success_status'),
        'showSeparator' => true,
        'body' => Yii::t('app','delete_success_alert'),
    ]);
endif;
?>

<div class="x_panel">

	<h4><?= Html::encode($this->title) ?></h4>
  <hr>
			<p>
				<?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app','add_admin'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
			</p>
			<?= GridView::widget([
				'dataProvider' => $dataProvider,
				 'tableOptions'=>['class'=>'table','id'=>'bg-table'],
				'columns' => [
					['class' => 'yii\grid\SerialColumn','header'=>Yii::t('app','order'),'contentOptions'=>['class'=>'text-center']],
          'username',
					'fullname',
          'position',
					'email',
					'role',
					[
						'class' => 'yii\grid\ActionColumn',
						'template' => ' {update} {delete}',
						'contentOptions'=>[
							'noWrap' => true
						],
						'options' => ['style'=>'width:10%;'],
						'header' => Yii::t('app','edit_delete'),
						'buttons' => [
							'update' => function($url,$model,$key){
								return Html::a('<i class="glyphicon glyphicon-edit"></i> ',$url,['class'=>'btn btn-warning btn-sm']);
							},
						  'delete' => function($url,$model,$key){
								return Html::a('<i class="glyphicon glyphicon-trash"></i> ',Yii::$app->user->identity->id == $model->id ? '#' : $url,['class'=>'btn btn-danger btn-sm','data-method'=>'post','disabled' => Yii::$app->user->identity->id == $model->id ? true : false,'data-confirm'=>'คุณต้องการลบผู้ใช้งานหรือไม่']);
							},
						],
					],
				],
			]); ?>
		</div>

<?php
$this->registerCss("
    #bg-table tr th{
        background:#3C474A;
        color:#FFF;

    }

    #bg-table tr th a{
        color:#FFF;
    }

");

$this->registerJs(
"

   $('#setting').parent('li').addClass('active');

   $('#setting3').parent('li').attr('id','setting_active');

   $('#setting_active').parent('ul').attr('style','display:block');

"
);
?>
