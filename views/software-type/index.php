<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SoftwareDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','software_type_setting');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="software-detail-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<ul class="nav nav-tabs">
  <li role="presentation" ><?= Html::a(Yii::t('app','software_setting'),['software-detail/index'])?></li>
  <li role="presentation" class="active"><?= Html::a($this->title,['software-type/index'])?></li>
</ul>
<br>
    <p>
        <?= Html::a(Yii::t('app','add_software_type'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-hover report-table'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
      				'attribute'=>'software_type',
      				'options'=>['style'=>'width:80%'],
      			],
            [
                    'header'=> Yii::t('app','edit_delete'),
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
    ]); ?>

</div>
