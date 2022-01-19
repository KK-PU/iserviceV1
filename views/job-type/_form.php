<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JobType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-sm-offset-3 col-sm-6">

    <div class="panel panel-info">
         <div class="panel-heading"> <?= Html::encode($this->title) ?></div>
            <div class="panel-body">

			    <?php $form = ActiveForm::begin(); ?>

			    <?= $form->field($model, 'job_type_name')->textInput(['maxlength' => true]) ?>

			    <div class="form-group">
			        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','save') : Yii::t('app','save_change'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			    	<?= Html::a(Yii::t('app','cancel'),['index'],['class'=>'btn btn-default']);?>
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
