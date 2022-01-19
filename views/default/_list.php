<?php

use yii\helpers\Html;

//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\Url;


echo GridView::widget([
    'id' => 'install-grid',
    'export' => false,
    'dataProvider' => $dataProvider,
    'resizableColumns' => false,
    'showPageSummary' => false,
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
    'responsive' => true,
    'hover' => true,
    'panel' => [
        'heading' => '<h3 class="panel-title"> Database backup files</h3>',
        'type' => 'primary',
        'showFooter' => false
    ],
    // set your toolbar
    'toolbar' => [
        ['content' =>
            Html::a('<i class="glyphicon glyphicon-plus"></i>  Create Backup File', ['create'], ['class' => 'btn btn-success create-backup'])
        ],
    ],
    'columns' => array(
        'name',
        'size:size',
        'create_time',
        'modified_time:relativeTime',
        [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{download_action}',
            'header' => 'Download Backup File',
            'buttons' => [

					'download_action' => function ($url,$model) {
						return Html::a('<span class="glyphicon glyphicon-import"></span>', '../_backup/'.$model['name'], [
							'title' => Yii::t('app', 'Download this backup'),
						]);
					}
				
                    ],
                ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{delete_action}',
            'header' => 'Delete file',
            'buttons' => [
                'delete_action' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>',
				['default/delete','file' => $model['name']], 
				['data-method' => 'post','title' => Yii::t('app', 'Delete this backup')]);
                }
                    ],

                ],        
    ),
]);
?>
