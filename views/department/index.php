<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\growl\Growl;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchDepartment */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','department_setting');
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
<div class="department-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <hr>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app','add_department'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' =>['class' => 'table'],
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
          				'attribute'=>'department_name',
          				'options'=>['style'=>'width:85%'],
          			],
                [
                    'header'=>Yii::t('app','edit_delete'),
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
                                        'data-confirm' => Yii::t('yii', 'confirm_delete'),
                                        'data-method' => 'post',
                                        'data-pjax' => '0',
                                        'class' => 'btn btn-danger btn-xs'
                            ]);
                        }
                    ]
                ],
            ],
            'layout'=>'{items}',

    ]); ?>

</div>
<?php
$this->registerJs("
	$(function(){
		$('#setting').addClass('active');
	});
");
?>
