<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\SearchJob */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="row">
	<div class="col-md-6 col-xs-12">

		<?= Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app','add_job_btn'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>

	</div>
	<div class="col-md-6 col-xs-12">

			<div class="text-right">
				<?php $form = ActiveForm::begin([
					'action' => ['index'],
					'method' => 'get',
					'options'=>['class'=>'form-inline'],
				]); ?>

				  <div class="form-group">
					<i class="glyphicon glyphicon-calendar"></i>
					<?=DatePicker::widget([
						'name'  => 'start_search',
						'language' => Yii::t('app','lang'),
						'dateFormat' => 'yyyy-MM-dd',
						'options'=>[
							'class'=>'form-control input-sm',
						],
						'clientOptions' => [
								'changeMonth' => true,
								'changeYear' => true,
								'showButtonPanel'=> true,
							],
						'value'=>$start_search
					]);?>

				  </div>
				  <div class="form-group">
					<?=DatePicker::widget([
						'name'  => 'end_search',
						'language' => Yii::t('app','lang'),
						'dateFormat' => 'yyyy-MM-dd',
						'options'=>['class'=>'form-control input-sm'],
							'clientOptions' => [
								'changeMonth' => true,
								'changeYear' => true,
								'showButtonPanel'=> true,
							],
						'value'=>$end_search
					]);?>
				  </div>
				   <div class="form-group">
						 <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> '.Yii::t('app','search'), ['class' => 'btn btn-success btn-sm','id'=>'search_btn']) ?>
				  </div>

				<?php ActiveForm::end(); ?>

		</div>
	</div>
</div>
