<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\DeviceType;
use app\models\Department;
use app\models\Employee;
use app\models\Device;
use app\models\Job;
use app\models\SoftwareDetail;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Device */
/* @var $form yii\widgets\ActiveForm */

$type = ArrayHelper::map(DeviceType::find()->all(),'id','device_type');

$department = ArrayHelper::map(Department::find()->all(),'id','department_name');

$employee = ArrayHelper::map(Employee::find()->all(),'id','user_fullname','department.department_name');

$software = ArrayHelper::map(SoftwareDetail::find()->all(),'id','software_detail','softwareType.software_type');

//get device id
$device = Yii::$app->request->get('Device');

?>

<div class="col-sm-offset-2 col-sm-8">

    <div class="panel panel-info">
        <div class="panel-heading"><i class="glyphicon glyphicon-list-alt"></i> <?=Yii::t('app','device_info')?></div>
            <div class="panel-body">

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <div role="tabpanel">
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">

                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-folder-open"></i>  <?=Yii::t('app','device_info')?></a></li>
                    <li role="presentation"><a href="#data_device" aria-controls="lan" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-hdd"></i> <?=Yii::t('app','device_detail')?> Hardware</a></li>
                    <li role="presentation"><a href="#data_software" aria-controls="software" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-hdd"></i> <?=Yii::t('app','device_detail')?>  Software</a></li>

                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home"><br>

        								<div class="form-group form-group-sm">
        									<div class="row">
                              <div class="col-sm-12">
              										<div class="col-sm-6">
                										<?= $form->field($model, 'device_id')->textInput(['class' => 'form-control','placeholder'=>Yii::t('app','device_id')]) ?>

                										<?= $form->field($model, 'device_name')->textInput(['class' => 'form-control','placeholder'=>Yii::t('app','device_name')]) ?>

                										<?= $form->field($model, 'serial_no')->textInput(['placeholder' => Yii::t('app','serial_no')]) ?>

                										<?= $form->field($model, 'device_price')->textInput(['placeholder'=> Yii::t('app','device_price')]) ?>

                                    <?php if(!$model->isNewRecord){?>

                                      <p style="padding-top:5px;">
                                        <?php
                                          if($model->date_use == "0000-00-00" || $model->date_use == "" || $model->device_status == "disable"){

                                          }else{
                                            echo Yii::t('app','date_use')." : ".Yii::$app->datethai->dateShortThai($model->date_use);
                                            echo "<br>".Yii::t('app','lifetime')."  : ".Device::checkOldDevice($model->date_use);

                                          }
                                        ?>
                                      </p>
                                    <?php } ?>
              										</div>
              										<div class="col-sm-6">
                                    <?php
                                       if(!$model->isNewRecord && !empty($model->image)){

                                         $image = Yii::$app->upload->getPhotosViewer($model->image);

                                          if(!empty($image)){

                                            foreach ($image as  $photo) {
                                              echo "<div class='text-center' style='display:inline-block;margin:5px;'>";
                                              echo $images = Html::img(Yii::$app->upload->getFileViewer($photo),
                                                ['class'=>'img-thumbnail','style'=>'width:80px;height:70px;']);

                                               echo "<br>".Html::a('<i class="glyphicon glyphicon-trash"></i> ลบ',
                                               ['id' => $model->id,'delete-image','name' => $photo],
                                               ['class' => 'text-danger','data-confirm' => 'คุณต้องการลบข้อมูลใช่หรือไม่']);

                                              echo "</div>";
                                            }

                                          }
                                        }
                                      ?>
                                        <?= $form->field($model, 'image[]')->fileInput(['multiple' => true]) ?>
              										</div>
                              </div>
        									</div>
                        </div>
								<hr>

                  <div class="form-group form-group-sm">

                        <div class="col-sm-6">

      										<?=
      												$form->field($model, 'device_type_id')->widget(Select2::classname(), [
      													'data' => $type,
      													'language' => 'th',
      													'options' => ['placeholder' => Yii::t('app','device_type')],
      													'pluginOptions' => [
      														'allowClear' => true
      													],
      												]);
      										?>

      										<?=
      												$form->field($model, 'department_id')->widget(Select2::classname(), [
      													'data' => $department,
      													'language' => Yii::t('app','lang'),
      													'options' => ['placeholder' => Yii::t('app','department_name')],
      													'pluginOptions' => [
      														'allowClear' => true
      													],
      												]);
      										?>
                    </div>

                    <div class="col-sm-6">
    										<?=
    												$form->field($model, 'employee_id')->widget(Select2::classname(), [
    													'data' => $employee,
    													'language' => 'th',
    													'options' => ['placeholder' => Yii::t('app','employee_id')],
    													'pluginOptions' => [
    														'allowClear' => true
    													],
    												]);
    										?>
    										<?php
                         if($model->date_use == "0000-00-00"){
                              $model->date_use = "";
                         }

                        echo $form->field($model, 'date_use')->widget(\yii\jui\DatePicker::classname(), [
    											//'language' => 'th',
    											'dateFormat' => 'yyyy-MM-dd',
    											'options' => ['class' => 'form-control input-sm','placeholder'=> Yii::t('app','date_use')],
    												'clientOptions' => [
    													'changeMonth' => true,
    													'changeYear' => true,
    													'showButtonPanel'=> true,
    												]

    											]);
    										?>
                    </div>
                </div>

              <div class="form-group form-group-sm">
									<div class="col-sm-6">
										<?php
											if(!$model->isNewRecord){
												    echo  $form->field($model, 'device_status')->radioList(['enable' => Yii::t('app','normal'),'disable' => Yii::t('app','deprecated') ]);
												}else{
												    echo $form->field($model, 'device_status')->hiddenInput(['value'=>'enable'])->label(false);
											}
										?>
									</div>
									<div class="col-sm-6" id="date_expire" <?php echo $model->device_status != 'disable' ? 'style="display:none"' : ''?>>
										<?php if(!$model->isNewRecord){?>

										<?php $model->date_expire == "0000-00-00" ? $model->date_expire = NULL : '';?>

										<?=$form->field($model, 'date_expire')->widget(\yii\jui\DatePicker::classname(), [
											'language' => Yii::t('app','lang'),
											'dateFormat' => 'yyyy-MM-dd',
											'options' => ['class' => 'form-control input-sm',],
											]);
										?>
										<?php } ?>
									</div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">

                    <?= $form->field($model, 'other_detail')->textArea(['rows'=>'4','maxlength' => true]) ?>


                </div>
            </div>

      </div>

                            <div role="tabpanel" class="tab-pane" id="data_device"><br>
                                <div class="form-group form-group-sm">
                                    <div class="col-sm-12">
                                        <div class="col-sm-6">
                                             <?= $form->field($model, 'device_brand')->textInput(['maxlength' => true,'placeholder'=> Yii::t('app','device_brand')]) ?>
                                        </div>

                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'cpu')->textInput(['maxlength' => true,'placeholder'=>Yii::t('app','cpu')]) ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <div class="col-sm-12">
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'device_model')->textInput(['maxlength' => true,'placeholder'=>Yii::t('app','device_model')]) ?>
                                        </div>

                                        <div class="col-sm-6">

                                            <?= $form->field($model, 'memory')->textInput(['maxlength' => true,'placeholder'=>Yii::t('app','memory')]) ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <div class="col-sm-12">
                                      <div class="col-sm-6">
                                          <?= $form->field($model, 'monitor')->textInput(['maxlength' => true,'placeholder'=>Yii::t('app','monitor')]) ?>
                                      </div>


                                        <div class="col-sm-6">
                                          <?= $form->field($model, 'harddisk')->textInput(['maxlength' => true,'placeholder'=>Yii::t('app','harddisk')]) ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <div class="col-sm-12">
                                      <div class="col-sm-6">
                                          <?= $form->field($model, 'mouse')->textInput(['maxlength' => true,'placeholder'=>Yii::t('app','mouse')]) ?>
                                      </div>


                                        <div class="col-sm-6">
                                          <?= $form->field($model, 'keyboard')->textInput(['maxlength' => true,'placeholder'=>Yii::t('app','keyboard')]) ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <div class="col-sm-12">
                                      <div class="col-sm-6">
                                         <?= $form->field($model, 'vender')->textInput(['maxlength' => true ,'placeholder'=>Yii::t('app','vender')]) ?>
                                      </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($model, 'warranty')->textInput(['maxlength' => true,'placeholder'=>Yii::t('app','warranty')]) ?>

                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="col-sm-6">
                                                 <?= $form->field($model, 'device_ip')->textInput(['maxlength' => true,'placeholder'=>Yii::t('app','device_ip')]) ?>

                                        </div>
                                        <div class="col-sm-6">
                    												<?= $form->field($model, 'mac')->textInput(['maxlength' => true,'placeholder'=>Yii::t('app','mac')]) ?>
                    										</div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                    <div class="col-sm-12">

                                        <?= $form->field($model, 'hardware_other')->textArea(['rows'=>'3','maxlength' => true]) ?>

                                    </div>
                                    </div>
                                </div>
                            </div>

							<div role="tabpanel" class="tab-pane" id="data_software"><br>
								<div class="form-group">
									<div class="col-md-12">
									<?php

                    if(!empty($software)){

                      echo "<table class='table'>";

                      foreach($software as $key => $val){

  											echo "<tr><th width='50%'>".$key."</th><th>".Yii::t('app','serial_no')."</th></tr>";

  											foreach($val as $vKey => $vVal){

  												$result = Device::checkSoftware($model->id,$vKey);

  												$checked = ($result == true) ? 'checked' : NULL;

                          $sn = ($result == false) ? 'disabled' : NULL;

                          echo "<tr>";
  												echo "<td>"."<label><input type='checkbox' data-id='".$vKey."'  class='software' name='software[]' value='".$vKey."' ".$checked.">&nbsp;&nbsp;";
  												echo $vVal;
  												echo "</td>";

                          echo "<td><input type='text' name='software_sn[][".$vKey."]' id='sn_".$vKey."' ".$sn."  value='".$model->findSnbySoftware($model->id,$vKey)."' ></td>";
                          echo "</tr>";
  											}

  										}
                      echo "</table>";

                    }

									?>

									</div>
								</div>

								<div class="form-group">
                    <div class="col-md-12">
                     	<hr>
                        <?= $form->field($model, 'software_detail')->textArea(['rows'=>'2','maxlength' => true]) ?>


                    </div>
                </div>

							</div>

        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <hr>
                <?php
                  if (!$model->isNewRecord) {

                      echo Html::a('<i class="glyphicon glyphicon-trash"></i> '.Yii::t('app','delete'), ['delete', 'id' => $model->id, 'Device[department_id]' => $device['department_id'],
                          'Device[device_type_id]' => $device['device_type_id']], [
                          'title' => Yii::t('yii', 'Delete'),
                          'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                          'data-method' => 'post',
                          'data-pjax' => '0',
                          'class' => 'btn btn-danger'
                      ]);
                      echo "&nbsp;&nbsp;";
                      echo Html::a('<i class="glyphicon glyphicon-print"></i> '.Yii::t('app','print'),['report/print-device-detail','id' => $model->id],['class' => 'btn btn-info','target' => '_blank']);
                  }
                ?>

                <div class="pull-right">

                    <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-floppy-disk"></i> '.Yii::t('app','save') : '<i class="glyphicon glyphicon-floppy-disk"></i> '.Yii::t('app','save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

                    <?php
                    //back to search device
                    echo $device != NULL ? Html::a(Yii::t('app','cancel'), ['search-device', 'Device[department_id]' => $device['department_id'],
                                'Device[device_type_id]' => $device['device_type_id']], ['class' => 'btn btn-default']) :
                            //back to all device
                            Html::a('<i class="glyphicon glyphicon-remove"></i> '.Yii::t('app','cancel'), ['index', 'page' => Yii::$app->request->get('page')], ['class' => 'btn btn-default']);
                    ?>
                </div>
            </div>
        </div>


          </div>

        <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
<?php
$this->registerJs("
	$(function(){

    $('.software').change(function(){
        if(this.checked){

          $('#sn_' + $(this).data('id')).attr('disabled' , false);

        }else{

          $('#sn_' + $(this).data('id')).val('');

          $('#sn_' + $(this).data('id')).attr('disabled' , true);

        }
    });

		$('#device').addClass('active');

		$('input[name=\"Device[device_status]\"]').click(function(val){
			setHide($(this).val());
		});

	function setHide(val){
        if(val == 'disable'){
            $('#date_expire').show();
        }else{

            $('#date_expire').hide();
        }
    }



	});


");
?>
