<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\growl\Growl;

$this->title = Yii::t('app','software_setting');

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
<div class="software-detail-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<ul class="nav nav-tabs">
  <li role="presentation" class="active"><?= Html::a($this->title,['index'])?></li>
  <li role="presentation"><?= Html::a(Yii::t('app','software_type_setting'),['software-type/index'])?></li>
</ul>
<br>
    <p>
        <?= Html::a(Yii::t('app','add_software'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-hover report-table'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
				'attribute'=>'softwareType.software_type',
				'options'=>['style'=>'width:40%'],
			],
			[
				'attribute'=>'software_detail',
				'options'=>['style'=>'width:45%'],
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

</div>
