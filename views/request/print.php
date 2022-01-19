<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Job;
/* @var $this yii\web\View */
/* @var $model app\models\Job */
$this->title = 'แบบฟอร์มแจ้งปัญหา / งานซ่อม';
?>

<div class="container">

   	<div class="col-md-offset-2 col-md-8">
		<h3 class="text-center"><?= Html::encode($this->title) ?>
			<div class="pull-right" id="non-printable">
					<button class="btn btn-info btn-sm" onclick="return window.print();"><i class="glyphicon glyphicon-print"></i>  พิมพ์รายงาน</button>
					<button class="btn btn-default btn-sm" onclick="return window.close();"><i class="glyphicon glyphicon-off"></i> ปิด</button>
			</div>
		</h3>
			<hr>
				<h4><u>ข้อมูลการแจ้ง</u></h4>
				
				<p>วันที่แจ้ง : <?=Job::getDateTime($model->job_date)?></p>
				<p>ชื่อผู้แจ้ง : <?=@$model->employee->user_fullname?></p>
				<p>ตำแหน่ง : <?=@$model->employee->user_position?></p>
				<p>หน่วยงาน/แผนก : <?=@$model->employee->department->department_name?></p>
				
	
				<p>ปัญหา/อาการเสีย : <?=$model->job_detail?></p>
				<hr>
				<h4><u>ข้อมูลการแก้ไข</u></h4>
				<p>ประเภทงาน : <?=!empty(@$model->jobType->job_type_name) ? @$model->jobType->job_type_name : ' '?></p>
				<p>หมวดหมู่อุปกรณ์ : <?=!empty(@$model->device->deviceType->device_type) ? @$model->device->deviceType->device_type : '  '?></p>
				<p>รหัสอุปกรณ์ : <?=!empty(@$model->device->device_id) ? @$model->device->device_id : '  '?></p>
				<p>ชื่ออุปกรณ์ : <?=!empty(@$model->device->device_name) ? @$model->device->device_name : '  '?></p>
				<p>ชื่อผู้ดำเนินการ : <?=!empty(@$model->user->fullname) ? @$model->user->fullname : ''?></p>
				<p>วันที่แก้ไข : <?=Job::getDateTime($model->job_start_date)?></p>
				<p>วันที่เสร็จ : <?=Job::getDateTime($model->job_success_date)?></p>
				<p>วิธีแก้ไข/สาเหตุ : <?= $model->job_how_to_fix?></p>
				<p>ค่าใช้จ่าย : <?=number_format($model->price)?></p>
				<p>ผลการแก้ไข : <?= Job::getStatus($model->job_status)?></p>
			<hr>	
				<table id="print-table" style="font-size:16px;text-align:center;margin-top:50px;" width="100%">
					<tr>
						
							<td style="width:40%">ลงชื่อ...............................................</td>
					
							<td style="width:20%"></td>

							<td style="width:40%">ลงชื่อ...............................................</td>
					</tr>
					<tr>
						
							<td style="width:40%;padding-top:15px" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(...............................................)</td>
					
							<td style="width:20%;padding-top:15px" ></td>

							<td style="width:40%;padding-top:15px" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(...............................................)</td>
					</tr>
					<tr>
						
							<td style="width:40%">ผู้แจ้งซ่อม</td>
					
							<td style="width:20%"></td>

							<td style="width:40%">ผู้ดำเนินการ</td>
					</tr>
					
				</table>	
		</div>	
				

					

</div>







