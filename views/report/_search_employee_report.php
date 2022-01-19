<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\models\Employee;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$employee = ArrayHelper::map(Employee::find()->all(),'id','user_fullname','department.department_name');
?>
<div class="row margin-job">
    <div class="col-md-offset-3 col-md-9">
        <div class="row">
            <?php
                $form = ActiveForm::begin([
                    'method' => 'get',
                    'options' => ['class' => ''],
					          'action'=>'index.php?r=report/'.Yii::$app->controller->action->id,
                ]);
            ?>
			<div class="col-md-4">
				<div class="form-group">
				  <label><?=Yii::t('app','select_employee')?></label>
				<?php

					echo Select2::widget([
						'name' => 'employee_id',
						'value' => $employee_id,
						'data' => $employee,
						'theme' => Select2::THEME_BOOTSTRAP  ,
						'options' => ['placeholder' => '---------------','class'=>'form-control input-sm','id' => 'employee_id']
					]);
				?>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label><?=Yii::t('app','start_date')?></label>
					<?=DatePicker::widget([
						'name' => 'start_date',
						'language' => Yii::t('app','lang'),
						'dateFormat' => 'yyyy-MM-dd',
						'options' => ['class' => 'form-control input-sm','placeholder' => Yii::t('app','start_date')],
						'clientOptions' => [
							'changeMonth' => true,
							'changeYear' => true,
							'showButtonPanel' => true,
						],
						'value' => $start_date
					]);
					?>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label><?=Yii::t('app','end_date')?></label>
					<?=DatePicker::widget([
						'name' => 'end_date',
						'language' => Yii::t('app','lang'),
						'dateFormat' => 'yyyy-MM-dd',
						'options' => ['class' => 'form-control input-sm','placeholder' => Yii::t('app','end_date')],
						'clientOptions' => [
							'changeMonth' => true,
							'changeYear' => true,
							'showButtonPanel' => true,
						],
						'value' => $end_date
					]);
					?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group" style="padding-top:25px">
					<?= Html::submitButton("<i class='glyphicon glyphicon-search'></i> ".Yii::t('app','search'), ['class' => 'btn btn-success btn-sm','id'=>'check_btn']) ?>
					<?=Html::a("<i class='glyphicon glyphicon-print'></i> ".Yii::t('app','print'),['employee-report','start_date'=>$start_date,'end_date'=>$end_date,'employee_id'=>$employee_id,'print'=>'print'],['class'=>'btn btn-default btn-sm','target'=>'_blank'])?>
				</div>
			</div>
            <?php ActiveForm::end(); ?>


        </div>
    </div>
</div>

<?php
$this->registerJs("

//check submit search btn

	$('#check_btn').click(function(){

		var search1 = $('#w1').val();
		var search2 = $('#w2').val();
		var employee = $('#employee_id').val();
		if(employee == ''){
			alert('Please Select Employee');
			return false;
		}

		if(search1 == '' || search2 == ''){
			alert('Please Select Start Date And End Date');
			return false;
		}
	});


");
?>
