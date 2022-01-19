<?php
use yii\helpers\Html;
use yii\helpers\Url;

//$this->title = Yii::t('app','job_order_list');
$this->title = "ตั้งค่าข้อมูลพื้นฐาน";
?>

<div class="system-default-index">
  <h4><i class="glyphicon glyphicon-cog"></i> <?= Html::encode($this->title); ?>  </h4>

<hr>


<ul class="nav nav-tabs">
  <li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">ตั้งค่าข้อมูลพื้นฐาน และ การแสดงผลหน้าแรก</a></li>
  <li class=""><a href="#profile" data-toggle="tab" aria-expanded="false">ตั้งค่า การ Login ก่อนแจ้งซ่อม</a></li>
  <li class=""><a href="#email" data-toggle="tab" aria-expanded="false">ตั้งค่า Email</a></li>
  <li class=""><a href="#profile" data-toggle="tab" aria-expanded="false">ตั้งค่า Line Notify</a></li>
</ul>
<div id="myTabContent" class="tab-content">
  <div class="tab-pane fade active in" id="home">
      <br>
      <div class="col-md-4">
          <p>
        <label>ชื่อระบบ</label>
         <input type="text" value="ระบบบริหารงาน IT">
         <br>
          <input type="radio"  name="home"> แสดง รายการแจ้งซ่อมในหน้าแรก<br>
          <input type="radio"  name="home"> แสดง Logo ในหน้าแรก<br>
          <?php
            echo Html::img(Yii::getAlias('@web').'/img/Image_2.png',['class' => 'img-thumbnail']);
          ?>
          <label>เปลี่ยนภาพ Home Logo</label>
          <input type="file">
        </p>


      </div>
  </div>
  <div class="tab-pane fade" id="profile">
    <br>
    <input type="radio"  name="login_require"> ผู้แจ้งซ่อมไม่ต้อง Login เข้าระบบ สามารถเลือกชื่อแล้วแจ้งซ่อมได้ทันที<br>
    <input type="radio"  name="login_require"> ผู้แจ้งซ่อมต้อง Login เข้าระบบก่อนแจ้งซ่อม<br>

  </div>
  <div class="tab-pane fade" id="email">
    <br>
      <input type="radio"  name="email">เมื่อมีการแจ้งซ่อม ส่ง email ไปยัง ผู้ดูแลระบบ<br>

          <input type="radio"  name="email">เมื่อสถานะงานซ่อมเป็น สำเร็จ ส่ง email ไปยัง ผู้แจ้งซ่อม<br>
  </div>
  <div class="tab-pane fade" id="dropdown2">
    <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater.</p>
  </div>
</div>


</div>
