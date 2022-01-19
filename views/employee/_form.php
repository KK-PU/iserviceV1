<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Department;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Employee */
/* @var $form yii\widgets\ActiveForm */

$department = ArrayHelper::map(Department::find()->all(),'id','department_name');

?>
<div class="col-sm-offset-3 col-sm-6">

    <div class="panel panel-info">
         <div class="panel-heading"> <?= Html::encode($this->title) ?></div>
            <div class="panel-body">

			    <?php $form = ActiveForm::begin(); ?>

			    <?= $form->field($model, 'user_fullname')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'user_position')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'user_phone')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'user_email')->textInput(['maxlength' => true]) ?>

          <div class="<?php echo $login_required == true ? 'show' : 'hide'?>">

          <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

			    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true,'placeholder' => !$model->isNewRecord ? Yii::t('app','blank_password') : NULL ]) ?>

         </div>

        <?=$form->field($model, 'department_id')->widget(Select2::classname(), [
            'data' => $department,
            'language' => Yii::t('app','lang'),
            'options' => ['placeholder' => Yii::t('app','department')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);?>

			    <div class="form-group">
			        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','save') : Yii::t('app','save_change'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			    	<?= Html::a(Yii::t('app','cancel'),['index'],['class'=>'btn btn-default'])?>
			    </div>

			    <?php ActiveForm::end(); ?>
			</div>
	</div>
</div>
<?php
$this->registerJs("
	$(function(){
		$('#setting').addClass('active');
	});
");
?>
