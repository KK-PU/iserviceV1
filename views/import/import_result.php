<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
?>
<div class="site-error">

<h1>เกิดข้อผิดพลาดในการนำเข้าข้อมูล</h1>
<?php
	foreach($result as $r){
		echo "<p class='text-danger'>".$r."</p>";
	}
?>
    <p class="well">
	  ข้อมูลถูกนำเข้าบางส่วน สำหรับข้อมูลที่เกิดข้อผิดพลาดจะไม่ถูกนำเข้าสู่ระบบ <br>
        โปรดตรวจสอบรูปแบบของข้อมูล และความถูกต้องภายใน ไฟล์ Excel ที่ต้องการนำเข้า  <?=Html::a('ลองอีกครั้ง',['index'])?>
    </p>

</div>
