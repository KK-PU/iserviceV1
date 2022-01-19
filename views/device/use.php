<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Job;
?>

<?php  echo $this->render('_search', ['model' => $model,'get_select'=>null,'active'=>$active]); ?>

 <?php echo $this->render('_status')?>

<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions'=>['class'=>'table table-hover device-table',],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'device_id',
        'deviceType.device_type',
        [
            'attribute'=>'DeviceName',
            'format'=>'html'
        ],
        'department.department_name',
        [
            'attribute' => 'DeviceRepair',
            'format' => 'raw',
            'value' => function($model) {
			
				$count = Job::find()->where(['device_id'=>$model->id])->count();
			
                return Html::a('ประวัติการซ่อม ('.$count.')',['report/repair-report', 'id' => $model->id], ['target' => '_blank']);
            }
        ],
        [
            'header' => 'รายละเอียด',
            'class' => 'yii\grid\ActionColumn',
            'options' => ['style' => 'width:10%;'],
            'template' => '{update}',
            'visible' => Yii::$app->user->identity->role == 1 ? true : false, //show for admin
            'buttons' => [

                'update' => function($url, $model, $key) {

            return Html::a('รายละเอียด', ['update', 'id' => $model->id,
                        'Device[department_id]' => $model->department_id,
                        'Device[device_type_id]' => $model->device_type_id,
            ]);
        },
            ]
        ],
    ],
    ]);
?>