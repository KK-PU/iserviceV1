<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Job;
use yii\helpers\Url;
use yii\bootstrap\Modal; 
?>



<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions'=>['class'=>'table table-hover device-table',],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
		['class' => 'yii\grid\CheckboxColumn'],
		[
            'attribute'=>'image',
            'format'=>'html',
			'value'=>function($model){
				return Html::img($model->getImageViewer(),  ['class'=>'img-thumbnail','width'=>'80','height'=>'80']);
			}
        ],
        'device_id',
        'deviceType.device_type',
        [
            'attribute'=>'DeviceName',
            'format'=>'html'
        ],

        'department.department_name',
        [
            'attribute'=>'DeviceRepair',
            'format'=>'raw',
            'value'=>function($model){
				
				$count = $model->repairCount($model->id);
				
				return Html::button('ประวัติการซ่อม ('.$count.')', [
                            'value' => Url::to('index.php?r=device/view-history&id='.$model->id),
                            'class' => 'btn btn-default btn-xs  view_detail'
                        ]);
				
				//return  Html::a('ประวัติการซ่อม  ('.$count.')','#',['data-toggle'=>'modal','data-target'=>'#myModal','onclick'=>'viewHistory('.$model->id.')']);
                //return Html::a('ประวัติการซ่อม ('.$count.')',['report/repair-report','id'=>$model->id],['target' => '_blank']);
            }
        ],

        [
            'attribute'=>'DeviceDetail',
            'format'=>'raw',
            'visible'=> Yii::$app->user->identity->role == 1 ? true : false ,//show for admin
            'value'=>function($model){
                 return  Html::a('รายละเอียด',['update','id'=>$model->id,'page'=>Yii::$app->request->get('page')],['class'=>'btn btn-default btn-xs']);
                 //return  Html::a('รายละเอียด','#',['data-toggle'=>'modal','data-target'=>'#myModal']);
            }
        ] 

    ],

]); ?>


<?php 

	Modal::begin([
        'header' => '<h4>ประวัติการซ่อม</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);
        echo "<div id='content'></div>";
    Modal::end();
	
$this->registerJs('

//show modal for view detail
$(".view_detail").click(function() {
	$("#modal").modal("show")
		.find("#content")
		.load($(this).attr("value"));
});

	  
	  jQuery("#btn-delete").click(function(){
	  
			if(confirm("คุณต้องการลบรายการที่เลือกทั้งหมดหรือไม่")){
				var keys = $(".grid-view").yiiGridView("getSelectedRows");
				
				//console.log(keys);
				
				if(keys.length > 0){
				
				  jQuery.post("'.Url::to(['delete-all']).'",{ids:keys.join()},function(){

				  });
				}
			}
	  });
	  

');
?>