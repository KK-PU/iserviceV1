<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Job;
use kartik\export\ExportMenu;

$this->title = Yii::t('app','device_maintenance');

$gridColumns = [
  [
      'attribute'=>'job_date',
      'options' => ['style' => 'width:10%'],
      'format' => 'html',
      'value' => function($model) {

          return Yii::$app->datethai->getDateTime($model->job_date);
      }
  ],
  [
      'attribute'=>'device.device_id',
      'options' => ['style' => 'width:10%'],
  ],
  [
      'attribute'=>'device.device_name',
      'options' => ['style' => 'width:10%'],
  ],
  [
      'attribute'=>'employee.user_fullname',
      'options' => ['style' => 'width:10%'],
  ],

  [
          'attribute'=>'job_detail',
          'options' => ['style' => 'width:15%'],
  ],
  [
          'attribute'=>'job_how_to_fix',
          'options' => ['style' => 'width:15%'],
  ],
   [
          'attribute'=>'UserName',
          'options' => ['style' => 'width:15%'],
          'value'=>'user.fullname',
   ],
   [
          'attribute'=>'price',
          'options' => ['style' => 'width:5%'],
          'contentOptions' => ['class'=>'text-right'],
          'value' => function($model){
            return number_format($model->price);
          }
   ],
  [
          'attribute'=>'job_status',
          'format'=>'html',
          'options' => ['style' => 'width:10%'],
          'value'=>function($model){
              return Yii::$app->getdata->getStatus($model->job_status);
          },
  ],


];

?>

<h4><?= Html::encode($this->title) ?></h4>

<p><?=Yii::t('app','device_type')?> : <?php echo !empty($device->deviceType->device_type) ? $device->deviceType->device_type : '' ?></p>

<p><?=Yii::t('app','device_id')?> : <?php echo $device->device_id?> </p>

<p><?=Yii::t('app','device_name')?> : <?php echo $device->device_name?></p>

<br>

    <div class="pull-right margin-print" id="non-printable">
      <?php
              echo ExportMenu::widget([
                  'dataProvider' => $dataProvider,
                  'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                  'columns' => $gridColumns,
                    'clearBuffers' => true,
	          'target' => '_self',
                  'columnSelectorOptions' => ['class' => 'btn btn-default btn-sm'],
                  'dropdownOptions' => ['class' => 'btn btn-default btn-sm'],
		  'showConfirmAlert' => false,
                  'exportConfig' => [
                      ExportMenu::FORMAT_CSV => false,
                      ExportMenu::FORMAT_HTML => false,
                      ExportMenu::FORMAT_TEXT => false,
                      ExportMenu::FORMAT_PDF => false,
		      ExportMenu::FORMAT_EXCEL => false
                  ]
              ]);
       ?>
        <button class="btn btn-info btn-sm" onclick="return window.print();"><i class="glyphicon glyphicon-print"></i> <?=Yii::t('app','print')?></button>
        <button class="btn btn-default btn-sm" onclick="return window.close();"><i class="glyphicon glyphicon-off"></i> <?=Yii::t('app','close')?></button>

    </div>

		<?= GridView::widget([
            'dataProvider' => $dataProvider,
			         'tableOptions'=>['class'=>'table'],
               'columns' => $gridColumns
            //'layout'=>'{items}'
    ]); ?>
