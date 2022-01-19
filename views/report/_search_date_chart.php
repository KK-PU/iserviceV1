<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

?>
<div class="row margin-job">
    <div class="col-md-12">
        <div class="pull-right">
            <?php
                $form = ActiveForm::begin([
                    'method' => 'get',
                    'options' => ['class' => 'form-inline'],
					          'action'=>'index.php?r=report/'.Yii::$app->controller->action->id,
                ]);
            ?>

            <div class="form-group">
                <i class="glyphicon glyphicon-search"></i> <?=Yii::t('app','start_date')?>
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

            <div class="form-group">
                <?=Yii::t('app','to')?>
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
            <div class="form-group">
                <?= Html::submitButton("<i class='glyphicon glyphicon-search'></i> ".Yii::t('app','search'), ['class' => 'btn btn-success btn-sm','id'=>'check_btn']) ?>
                <?=Html::a("<i class='glyphicon glyphicon-print'></i> ".Yii::t('app','print'),[$link,'start_date'=>$start_date,'end_date'=>$end_date,'print'=>true],['class'=>'btn btn-default btn-sm','target'=>'_blank'])?>
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

		if(search1 = '' || search2 == ''){
			alert('กรุณาเลือก วันที่เริ่มต้น และ วันที่สิ้นสุด');
			return false;
		}

	});

");
?>
