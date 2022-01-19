<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Employee;
use app\models\JobType;
use app\models\Device;
use yii\helpers\ArrayHelper;
use janisto\timepicker\TimePicker;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;

$this->title = Yii::t('app','job_order_form');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h4><i class="glyphicon glyphicon-book"></i> <?= Html::encode($this->title) ?></h4>

	<hr>

</div>

<?php

$department = !empty(Yii::$app->user->identity->department_id) ? Yii::$app->user->identity->department_id : '';

$device = ArrayHelper::map(Device::find()
->select(['id,CONCAT_WS("",device_id," - ",device_name) AS device_name,device_type_id'])
->where(['department_id' => $department,'device_status' => 'enable'])
->all(),'id','device_name','deviceType.device_type');

$job_type = ArrayHelper::map(JobType::find()->all(),'id','job_type_name');


$model->job_date = Yii::$app->formatter->asDateTime(time(), 'php:Y-m-d H:i:s');

?>

<div class="row">

    <div class="col-md-offset-3 col-md-6">

		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title"><?=Yii::t('app','job_order')?></h3>
		  </div>
		  <div class="panel-body">

      <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="col-md-12">

                <div class="form-group" >
                     <div class="col-md-12">
                            <?=$form->field($model, 'job_date')->widget(TimePicker::className(), [
                                'mode' => 'datetime',
                                'options' => ['class' => 'form-control input-sm','disabled' => 'disabled'],
                                'clientOptions' => [
                                    'dateFormat' => 'yy-mm-dd',
                                    'timeFormat' => 'HH:mm',
                  									'changeMonth' => true,
                  									'changeYear' => true,
                  									'showButtonPanel'=> true,
                                ],
                            ]);
                            ?>


                    </div>
                </div>

                <div class="form-group" >
                    <div class="col-md-12">
                      <?=
                      $form->field($model, 'job_type_id')->widget(Select2::classname(), [
                          'data' => $job_type,
                          'hideSearch' => 'true',
                          'language' => 'th',
                          'options' => ['placeholder' => Yii::t('app','select_job_type')],
                          'pluginOptions' => [
                              'allowClear' => true
                          ],
                      ]);
                      ?>
                    </div>
                </div>

              <?= $form->field($model, 'job_employee_id')->hiddenInput(['value' => Yii::$app->user->identity->id ])->label(false)?>

        </div>

        <div class="col-md-12" >

            <div class="form-group" >
                <div class="col-md-12">
                  <?=
                  $form->field($model, 'device_id')->widget(Select2::classname(), [
                      'data' => $device,
                      'language' => Yii::t('app','lang'),
                      'options' => ['class' => 'form-control input-sm', 'placeholder' => Yii::t('app','device_name')],
                      'pluginOptions' => [
                          'allowClear' => true
                      ],

                  ]);
                  ?>
                </div>
            </div>

            <div class="form-group" >
                <div class="col-md-12">
                    <?= $form->field($model, 'job_detail')->textArea(['rows'=>'4','class'=>'form-control input-sm'])?>
                </div>
            </div>
			      <div class="form-group" >
                <div class="col-md-12">
                        
                        <?= $form->field($model, 'phone')->textInput(['class'=>'form-control input-sm','value' => Yii::$app->user->identity->user_phone])?>

                </div>
            </div>



            <div class="form-group" >
              <div class="col-md-12">
                      <?php echo $form->field($model, 'request_file[]')->fileInput(['multiple' => true])?>

              </div>
              <div class="col-md-12">
                <?php
                 $request_file = Yii::$app->upload->getMultipleViewer($model->request_file);
                 $file = "";

                 if(!empty($request_file)){

                   $file = "<div>";
                      $i = 1;
                      foreach($request_file as $photo){

                       if(file_exists(Yii::$app->upload->getUploadPath().$photo)){

                           $file .= Html::a('<i class="glyphicon glyphicon-link"></i> '.Yii::t('app','file'),Yii::$app->upload->getUploadUrl().$photo, [ 'class' => 'btn btn btn-xs' , 'target' => '_blank']);
                           $file .= Html::a('<i class="glyphicon glyphicon-trash"></i>',
                                    ['id' => $model->id,'delete-request-file','name' => $photo],
                                    ['class' => 'text-danger','data-confirm' => 'คุณต้องการลบข้อมูลใช่หรือไม่']);
                           $i++;
                       }
                      }

                    $file .= "</div>";

                 }

                 echo $file;
                 ?>

              </div>
              <br>

          </div>

        </div>


		<?=$form->field($model,'job_status')->hiddenInput(['value'=>'request'])->label(false)?>

        <div class="form-group">

            <div class="col-md-12">
                <hr>
                <?php
                if (!$model->isNewRecord) {

                    /*echo Html::a('<i class="glyphicon glyphicon-trash"></i> ลบข้อมูล', ['delete', 'id' => $model->id, 'start_search' => Yii::$app->request->get('start_search'), 'end_search' => Yii::$app->request->get('end_search')], [
                        'title' => Yii::t('yii', 'Delete'),
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                        'class' => 'btn btn-danger'
                    ]);*/
                }else{
                   echo $form->field($model,'job_date')->hiddenInput(['value'=> date("Y-m-d H:i:s")])->label(false);
                }
                ?>

                <div class="pull-right">
                    <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-floppy-disk"></i> '.Yii::t('app','save') : '<i class="glyphicon glyphicon-floppy-disk"></i> '.Yii::t('app','save_change'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>

                    <?= Html::a('<i class="glyphicon glyphicon-remove"></i> '.Yii::t('app','cancel'), ['index', 'start_search' => Yii::$app->request->get('start_search'), 'end_search' => Yii::$app->request->get('end_search')], ['class' => 'btn btn-default']) ?>
                </div>
            </div>

        </div>


<?php ActiveForm::end(); ?>

    </div>

  </div>
</div>

</div>

<?php
$this->registerJs("
	$(function(){
		$('#job').addClass('active');
	});
");
?>
