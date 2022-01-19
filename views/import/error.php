<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        ข้อมูลถูกนำเข้าบางส่วน สำหรับข้อมูลที่เกิดข้อผิดพลาดจะไม่ถูกนำเข้าสู่ระบบ
    </p>
    <p>
        โปรดตรวจสอบรูปแบบของข้อมูล และความถูกต้องภายใน ไฟล์ Excel ที่ต้องการนำเข้า <?=Html::a('ลองอีกครั้ง',['index'])?>
    </p>

</div>
