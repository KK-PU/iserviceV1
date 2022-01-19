<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\SoftwareType;
/* @var $this yii\web\View */
/* @var $model app\models\SoftwareDetail */
/* @var $form yii\widgets\ActiveForm */

$software_type = ArrayHelper::map(SoftwareType::find()->all(),'id','software_type');

?>

<div class="col-sm-offset-3 col-sm-6">

    <div class="panel panel-info">
         <div class="panel-heading"> <?= Html::encode($this->title) ?></div>
            <div class="panel-body">


    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'software_type_id')->dropDownList($software_type) ?>


    <?= $form->field($model, 'software_detail')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? Yii::t('app','save') : Yii::t('app','save_change'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?= Html::a(Yii::t('app','cancel'),['index'],['class'=>'btn btn-default'])?> </div>

    <?php ActiveForm::end(); ?>

	</div>
</div>

</div>
