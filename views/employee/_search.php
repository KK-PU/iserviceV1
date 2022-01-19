<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Employee;

$employee = ArrayHelper::map(Employee::find()->all(),'id','user_fullname','department.department_name');


?>

<div class="row">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="col-md-3">
      <?=$form->field($model, 'id')->widget(Select2::classname(), [
        'data' => $employee,
        'language' => Yii::t('app','lang'),
        'options' => ['placeholder' => Yii::t('app','find_staff')],
        'pluginOptions' => [
          'allowClear' => true
        ],
         'addon' => [
         'prepend' => [
           'content' => '<i class="glyphicon glyphicon-search"></i>',
         ],
       ]
      ])->label(false);?>
  </div>
  <div class="col-md-2">
    <div class="form-group">
        <?= Html::submitButton( Yii::t('app','search'), ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
  </div>
  <div class="col-md-7">
      <div class="text-right">
        <?= Html::a( Yii::t('app','add_staff'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
      </div>
  </div>
  <?php ActiveForm::end(); ?>

</div>
