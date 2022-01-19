<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Department;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('app','edit_profile');
?>

<h4><i class='glyphicon glyphicon-user'></i> <?= Html::encode($this->title) ?></h4>
      <hr>
<div class="col-md-offset-3 col-md-6">

    <?php
        if(Yii::$app->session->hasFlash('save_user_profile')):

            echo"<p class='alert alert-success'><i class='glyphicon glyphicon-ok'></i>  ".Yii::t('app','edit_success')."</p>";
        endif;
    ?>

      <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

      <?= $form->field($model, 'fullname')->textInput() ?>

      <?= $form->field($model, 'position')->textInput() ?>

      <?= $form->field($model, 'email')->textInput() ?>

      <?= $form->field($model, 'username')->textInput() ?>

      <?= $form->field($model, 'oldPassword')->passwordInput() ?>

      <?= $form->field($model, 'newPassword')->passwordInput() ?>

      <?= $form->field($model, 'confirmPassword')->passwordInput() ?>

      <div class="form-group">
          <?= Html::submitButton(Yii::t('app','save_change'), ['class' => 'btn btn-primary btn-sm', 'name' => 'signup-button']) ?>
      </div>

      <?php ActiveForm::end(); ?>
</div>

<?php
  $this->registerJs("$('#edit-profile').addClass('menu-active');");
