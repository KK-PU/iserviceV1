<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Job;
?>

<p><b><?=Yii::t('app','problem_info')?></b></p>
      <?=
      DetailView::widget([
          'model' => $model,
          'template' => '<tr><th width="15%">{label}</th><td>{value}</td></tr>',
          'attributes' => [
            [
              'label' => Yii::t('app','job_request_date'),
              'format' => 'raw',
              'value' => Job::getDateTime($model->job_date),
            ],
            'employee.user_fullname',
            'employee.user_position',
            'employee.department.department_name',
            'job_detail',


          ],
      ])
      ?>

  <hr><p><b><?=Yii::t('app','solution')?></b></p>
          <?=
      DetailView::widget([
          'model' => $model,
          'template' => '<tr><th width="15%">{label}</th><td>{value}</td></tr>',
          'attributes' => [

          'device.deviceType.device_type',
          'device.device_id',
          'device.device_name',
          'jobType.job_type_name',
          [
            'label' => Yii::t('app','operator'),
            'format' => 'raw',
            'value' => !empty($model->user->fullname) ? $model->user->fullname : ''
          ],
          [
            'label' => Yii::t('app','job_start_date'),
            'format' => 'raw',
            'value' => Job::getDateTime($model->job_start_date),
          ],
          [
            'label' => Yii::t('app','job_success_date'),
            'format' => 'raw',
            'value' => Job::getDateTime($model->job_success_date),
          ],
            'job_how_to_fix',
          [
                'label' => Yii::t('app','status'),
                'format' => 'raw',
                'value'=> Job::getStatus($model->job_status),
          ],
		

          ],
		  
		  
      ])
      ?>

      <hr>
      <p>รบกวนช่วยประเมินความพึงพอใจในการบริการแผนก IT ตามลิ้งค์ >> https://forms.office.com/r/7qX9EGBqpv      
      </p>   
      <p>พนักงานทุกท่านสามารถตรวจสอบหรือติดตามปัญหาที่แจ้งได้ที่ https://it.estarpcl.com
        <br> โดยใช้ username เป็นชื่อภาษาอังกฤษ  และรหัสผ่าน เป็น password
      </p>
			
