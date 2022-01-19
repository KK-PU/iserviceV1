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


$employee = ArrayHelper::map(Employee::find()->all(),'id','user_fullname','department.department_name');

$job_type = ArrayHelper::map(JobType::find()->all(),'id','job_type_name');

$model->job_date = Yii::$app->formatter->asDateTime(time(), 'php:Y-m-d H:i:s');
?>

<div class="row">
    <br>
    <div class="col-md-offset-3 col-md-6">

		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title"><?=Yii::t('app','job_order')?></h3>
		  </div>
		  <div class="panel-body">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="col-md-12">

                <div class="form-group" >

                      <?=
                      $form->field($model, 'job_employee_id')->widget(Select2::classname(), [
                          'data' => $employee,
                          'language' => Yii::t('app','lang'),
                          'options' => ['class' => 'form-control input-sm', 'placeholder' => Yii::t('app','find_staff')],
                          'pluginOptions' => [
                              'allowClear' => true
                          ],
                      ])->label(Yii::t('app','find_staff'));
                      ?>

                </div>

            <div class="form-group" >
		                <?php
				              echo $form->field($model, 'device_id')->widget(DepDrop::classname(), [
                          'type'=>DepDrop::TYPE_SELECT2,
                         'pluginOptions'=>[
                             'depends'=>['request-job_employee_id'],
                             'placeholder' => Yii::t('app','device_name'),
                             'url' => Url::to(['/request/get-device'])
                         ],
                     ]);
                    ?>
            </div>

              <div class="form-group" >
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

            <div class="form-group" >
                  <?= $form->field($model, 'job_detail')->textArea(['rows'=>'4','class'=>'form-control input-sm'])?>
            </div>
			      <div class="form-group" >
                <?= $form->field($model, 'phone')->textInput(['class'=>'form-control input-sm'])?>
            </div>


            <div class="form-group" >
                      <?php echo $form->field($model, 'request_file[]')->fileInput(['multiple' => true])?>
                      <small class="text-primary">** <?php echo Yii::t('app','file_support') ?></small>
              </div>

              <?=$form->field($model,'job_date')->hiddenInput(['value'=> date("Y-m-d H:i:s")])->label(false)?>

      		    <?=$form->field($model,'job_status')->hiddenInput(['value'=>'request'])->label(false)?>

              <div class="form-group">

                      <hr>
                      <?php
                      if (!$model->isNewRecord) {

                          echo Html::a('<i class="glyphicon glyphicon-trash"></i> ลบข้อมูล', ['delete', 'id' => $model->id, 'start_search' => Yii::$app->request->get('start_search'), 'end_search' => Yii::$app->request->get('end_search')], [
                              'title' => Yii::t('yii', 'Delete'),
                              'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                              'data-method' => 'post',
                              'data-pjax' => '0',
                              'class' => 'btn btn-danger'
                          ]);
                          echo "&nbsp;";
                          echo Html::a('<i class="glyphicon glyphicon-print"></i> พิมพ์', ['print', 'id' => $model->id], ['target' => '_blank', 'class' => 'btn btn-info']);
                      }
                      ?>

                      <div class="pull-right">
                          <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-floppy-disk"></i> '.Yii::t('app','save') : '<i class="glyphicon glyphicon-floppy-disk"></i> '.Yii::t('app','save_change'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>

                          <?= Html::a('<i class="glyphicon glyphicon-remove"></i> '.Yii::t('app','cancel'), ['index', 'start_search' => Yii::$app->request->get('start_search'), 'end_search' => Yii::$app->request->get('end_search')], ['class' => 'btn btn-default']) ?>
                      </div>
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
