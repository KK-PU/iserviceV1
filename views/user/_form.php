<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;

?>
<div class="col-md-offset-3 col-md-6">

	<div class="x_panel">

			<h4> <?= Html::encode($this->title) ?></h4>
			<hr>

		  <div class="x_content ">

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'fullname')->textInput(['autofocus' => true,'class'=>'form-control input-sm']) ?>

                <?= $form->field($model, 'position')->textInput(['class'=>'form-control input-sm']) ?>

                <?= $form->field($model, 'email')->textInput(['class'=>'form-control input-sm']) ?>

                <?= $form->field($model, 'username')->textInput(['class'=>'form-control input-sm']) ?>

                <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control input-sm','placeholder'=>'']) ?>

                <?=
                $form->field($model, 'role')->dropDownList([
                    User::ROLE_SUPPORT => $model->getRoles(User::ROLE_SUPPORT),
                    User::ROLE_ADMIN => $model->getRoles(User::ROLE_ADMIN),
									],['prompt'=>'-- Select Role --','class'=>'form-control input-sm'])
                ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app','save'), ['class' => 'btn btn-primary btn-sm']) ?>
                    <?= Html::a(Yii::t('app','cancel'),['index'],['class'=>'btn btn-default btn-sm'])?>
                </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>
</div>
