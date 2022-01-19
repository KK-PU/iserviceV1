<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app','login');
?>


<link rel="stylesheet" type="text/css" href="dist/component.css" />
<script src="dist/modernizr.custom.js"></script>
 
<div class="row" style="margin-top:30px">

    <div class="col-md-4 col-md-offset-4">

		<?php if (Yii::$app->session->hasFlash('registerSuccess')): ?>

			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <br>คุณได้ลงทะเบียนเข้าใช้งานระบบเรียบร้อยแล้ว <br>คุณสามารถ Login เข้าสู่ระบบได้ทันที
			</div>

		<?php endif; ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-lock"></i> <?=Yii::t('app','login')?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin() ?>

                <?= $form->field($model, 'username')->label(Yii::t('app','username')) ?>

                <?= $form->field($model, 'password')->passwordInput()->label(Yii::t('app','password')) ?>

                <?= Html::submitButton(Yii::t('app','login'), ['class' => 'btn btn-primary btn-block', 'tabindex' => '3']) ?>

                <!-- <?//= Html::a(Yii::t('app','register'),['site/register'],['class' => 'btn btn btn-block']) ?> -->
				
                <?php ActiveForm::end(); ?>
            </div>
        </div>


    </div>
</div>

<div class="md-modal md-effect-4" id="modal-4">
	<div class="md-content" style="text-align: center">
		<h3>IT SERVICE.</h3>
		<div>
			<p>สวัสดีครับ...มีอะไรให้เราช่วยมั้ยครับ</p>
			<img src="img/manc.png">
			<p>
				สอบถามการใช้งานระบบ หรือ แจ้งปัญหาอุปกรณ์ไอที ง่ายๆ แค่คลิก  <a href="http://line.me/ti/p/%40hgr6869d" style="color:#00f285"> Line </a> 
				
			</p>
			<a class="md-close" style="text-decoration: none;color:black;cursor: pointer;">X</a>
		</div>
	</div>
</div>

		
<div class="row" style="display: none;">
	<a href="#" style="right: 10px;bottom: 50px;position:fixed;text-align: center;cursor: pointer;" class="md-trigger"  data-modal="modal-4"><small>พูดคุยกับ IT ผ่าน LINE@...คลิกเลยจ้า..</small><br><img src="img/boy.png" ></a>

		<!-- classie.js by @desandro: https://github.com/desandro/classie -->
		<script src="dist/classie.js"></script>
		<script src="dist/modalEffects.js"></script>

		<!-- for the blur effect -->
		<!-- by @derSchepp https://github.com/Schepp/CSS-Filters-Polyfill -->
		<script>
			// this is important for IEs
			var polyfilter_scriptpath = '/js/';
		</script>
		<script src="dist/cssParser.js"></script>
</div>		