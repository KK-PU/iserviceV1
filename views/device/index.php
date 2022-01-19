<?php
use yii\helpers\Html;
use kartik\growl\Growl;
use yii\grid\GridView;
use app\models\Job;
use app\models\Device;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use branchonline\lightbox\Lightbox;

  if(Yii::$app->session->hasFlash('save')):
      echo Growl::widget([
          'type' => Growl::TYPE_SUCCESS,
          'icon' => 'glyphicon glyphicon-ok-sign',
          'title' => 'สำเร็จ',
          'showSeparator' => true,
          'body' => 'บันทึกข้อมูลของคุณเรียบร้อยแล้ว'
      ]);
  endif;

  if(Yii::$app->session->hasFlash('delete')):
      echo Growl::widget([
          'type' => Growl::TYPE_DANGER,
          'icon' => 'glyphicon glyphicon-ok-sign',
          'title' => 'สำเร็จ',
          'showSeparator' => true,
          'body' => 'ลบข้อมูลของคุณเรียบร้อยแล้ว'
      ]);
  endif;
?>

<div class="device-index">

    <?php  echo $this->render('_search', ['model' => $model,'get_select'=>$get_select,'active'=>$active]); ?>

	  <?php echo $this->render('_status')?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions'=>['class'=>'table table-hover device-table',],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
    		    ['class' => 'yii\grid\CheckboxColumn'],

            [
                'attribute' => 'image',
                'headerOptions' => ['class' => 'text-center'],
                'options' => ['style' => ['width' => '10%']],
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'value' => function($model){

                    $no_picture = Html::img(Yii::$app->upload->noImage(),
                        ['class'=>'img-thumbnail','style'=>'width:80px;height:60px;']);

                    $photos = Yii::$app->upload->getPhotosViewer($model->image);

                    $img = '';

                    $i = 1;

                    if(!empty($photos)){

                        foreach ($photos as  $photo) {

                            if(file_exists(Yii::$app->upload->getUploadPath().$photo)){

                                $hide = $i > 1 ? 'hide' : '';

                                $img .= Html::a(
                                    Html::img(Yii::$app->upload->getUploadUrl().$photo,
                                    ['class'=>"img-thumbnail" ,'style'=>'max-width:70px;max-height:70px;']),
                                    Yii::$app->upload->getUploadUrl().$photo,[
                                        'data-lightbox' => $model->id,
                                        'data-title' => $model->device_name,
                                        'class' => $hide
                                    ]);
                                $i++;
                            }
                        }
                    }

                    $show_image = !empty($img) ? $img : $no_picture;

                    return $show_image."<br>".$model->device_id;
                }
            ],


			[
                'attribute'=>'deviceType.device_type',
				'options'=>['style'=>['width'=>'15%']],
                'format'=>'html',
            ],
			[
                'attribute'=>'device_name',
				//'options'=>['style'=>['width'=>'15%']],
                'format'=>'html',
            ],
			[
                'attribute'=>'department.department_name',
				'options'=>['style'=>['width'=>'20%']],
                'format'=>'html',
            ],
			[
                'attribute'=>'employee_id',
				'options'=>['style'=>['width'=>'15%']],
                'format'=>'html',
				'value'=>function($model){
					return !empty($model->employee->user_fullname) ? $model->employee->user_fullname : '' ;
				}
            ],
            [
                'attribute'=>'DeviceRepair',
				'options'=>['style'=>['width'=>'10%']],
                'format'=>'raw',
                'value'=>function($model){

    				          $count = $model->repairCount($model->id);

    				              return Html::button(Yii::t('app','device_repair').' ('.$count.')', [
                                'value' => Url::to('index.php?r=device/view-history&id='.$model->id),
                                'class' => 'btn btn-default btn-xs  view_detail'
                            ]);
                 }
            ],
            [
                'attribute'=>'DeviceDetail',
                'format'=>'raw',
                'visible'=> Yii::$app->user->identity->role == 'admin' ? true : false ,//show for admin
                'value'=>function($model){
                     return  Html::a(Yii::t('app','device_detail'),['update','id'=>$model->id,'page'=>Yii::$app->request->get('page')],['class'=>'btn btn-default btn-xs']);
                }
            ]
        ],

    ]); ?>


    <?php

    	Modal::begin([
            'header' => '<h4>'.Yii::t('app','device_repair').'</h4>',
            'id' => 'modal',
            'size' => 'modal-lg',
        ]);
            echo "<div id='content'></div>";
        Modal::end();


    $this->registerCssFile(Yii::getAlias('@web')."/css/lightbox.min.css");

    $this->registerJsFile(Yii::getAlias('@web')."/js/lightbox-plus-jquery.min.js");


    $this->registerJs('

    //show modal for view detail
    $(".view_detail").click(function() {
    	$("#modal").modal("show")
    		.find("#content")
    		.load($(this).attr("value"));
    });


    	  jQuery("#btn-delete").click(function(){

    			if(confirm("'.Yii::t('app','confirm_delete_all').'")){
    				var keys = $(".grid-view").yiiGridView("getSelectedRows");

    				if(keys.length > 0){

    				  jQuery.post("'.Url::to(['delete-all']).'",{ids:keys.join()},function(){

    				  });
    				}else{
                alert("'.Yii::t('app','please_select_items').'");
            }
    			}
    	  });


    ');
    ?>

</div>
