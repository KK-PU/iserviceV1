<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app','import_device');
?>
    <h4><?= Html::encode($this->title) ?></h4>
		<hr>
			<div class="row">
				<div class="col-md-offset-3 col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading"><?=Yii::t('app','select_file_excel')?></div>
						<div class="panel-body">

							<p class="alert alert-warning"><b><?=Yii::t('app','import_check_device_type_department')?></b></p>

							<div class="col-md-12">
								<img src="img/device.png" class="img-responsive">
							</div>

							<?php
							$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

							<?= $form->field($model, 'file')->fileInput() ?>
							<hr>
              <p><?=Yii::t('app','check_again')?></p>
							<div class="form-group">
								<?= Html::submitButton(Yii::t('app','confirm_import'), ['class' => 'btn btn-success']) ?>
								<?= Html::a(Yii::t('app','cancel'),['index'],['class'=>'btn btn-default'])?>
							</div>

							<?php ActiveForm::end(); ?>

						</div>
					</div>
				</div>
			</div>
