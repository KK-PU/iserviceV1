<?php

use yii\helpers\Html;
use app\models\Job;
use app\models\Device;
use app\models\Employee;

?>


      <div class="col-md-12">
        <h3 class="text-center"><?= Html::encode($this->title) ?>
            <div class="pull-right" id="non-printable">
                <button class="btn btn-info btn-sm" onclick="return window.print();"><i class="glyphicon glyphicon-print"></i>  <?=Yii::t('app','print')?></button>
                <button class="btn btn-default btn-sm" onclick="return window.close();"><i class="glyphicon glyphicon-off"></i> <?=Yii::t('app','close')?></button>
            </div>
        </h3>
      </div>

        <h4><?=Yii::t('app','device_info')?> : <?= $model->device_name ?></h4>

        <table class="table table-bordered" style="font-size:13px;">
            <tr>
                <td width="18%" class="text-right"> <?=Yii::t('app','device_id')?> :</td>
                <td width="28%" >  <?= $model->device_id ?></td>
                <td width="22%" class="text-right"><?=Yii::t('app','device_name')?> :</td>
                <td ><?= $model->device_name ?></td>
            </tr>

            <tr>
                <td class="text-right"><?=Yii::t('app','serial_no')?> :</td>
                <td><?= $model->serial_no ?></td>
                <td class="text-right"><?=Yii::t('app','device_price')?> :</td>
                <td><?= $model->device_price ?></td>
            </tr>

              <?php
                  echo "<tr><td class='text-right'>".Yii::t('app','date_use')." :</td><td>" . Yii::$app->datethai->getDate($model->date_use)."</td>";
                  echo "<td class='text-right'>".Yii::t('app','lifetime')." :</td><td>". Device::checkOldDevice($model->date_use) . "</td></tr>";
              ?>

              <tr>
                  <td class="text-right"><?=Yii::t('app','device_type')?> :</td>
                  <td><?php echo !empty($model->deviceType->device_type) ? $model->deviceType->device_type : '' ?></td>
                  <td class="text-right"><?=Yii::t('app','department_name')?> :</td>
                  <td><?php echo !empty($model->department->department_name) ? $model->department->department_name : '' ?></td>
              </tr>
              <tr>
                  <td class="text-right"><?=Yii::t('app','employee_id')?> :</td>
                  <td><?php echo Employee::getEmployeeName($model->employee_id)?></td>
                  <td class="text-right"><?=Yii::t('app','hardware_other')?> :</td>
                  <td><?php echo $model->other_detail ?></td>
              </tr>
              <tr>
                  <td class="text-right"><?=Yii::t('app','device_status')?> :</td>
                  <td><?php echo $model->getStatus($model->device_status) ?></td>
                  <?php
                      if($model->device_status == 'disable'){
                  ?>
                          <td class="text-right"><?=Yii::t('app','date_expire')?> :</td>
                          <td><?php echo Yii::$app->datethai->getDate($model->date_use) ?></td>
                  <?php
                      }else{
                         echo "<td></td><td></td>";
                      }
                  ?>
              </tr>

        </table>


        <h4>Hardware</h4>

        <table class="table table-bordered" style="font-size:13px;">
          <tr>
              <td width="18%" class="text-right"><?=Yii::t('app','device_brand')?> :</td>
              <td width="28%"><?= $model->device_brand ?></td>
              <td width="22%" class="text-right"><?=Yii::t('app','device_model')?> :</td>
              <td><?= $model->device_model ?></td>
          </tr>
          <tr>
              <td class="text-right"><?=Yii::t('app','cpu')?> :</td>
              <td><?= $model->cpu ?></td>
              <td class="text-right"><?=Yii::t('app','memory')?> :</td>
              <td><?= $model->memory ?></td>
          </tr>
          <tr>
              <td class="text-right"><?=Yii::t('app','harddisk')?> :</td>
              <td><?= $model->harddisk ?></td>
              <td class="text-right"><?=Yii::t('app','monitor')?> :</td>
              <td><?= $model->monitor ?></td>
          </tr>
          <tr>
              <td class="text-right"><?=Yii::t('app','device_ip')?> :</td>
              <td><?= $model->device_ip ?></td>
              <td class="text-right"><?=Yii::t('app','mac')?> :</td>
              <td><?= $model->mac ?></td>
          </tr>
          <tr>
              <td class="text-right"><?=Yii::t('app','vender')?>  :</td>
              <td><?= $model->vender ?></td>
              <td class="text-right"><?=Yii::t('app','warranty')?> :</td>
              <td><?= $model->warranty ?></td>
          </tr>
        </table>

        <?php
            if(!empty($software)){

                    echo "<h4>Software</h4>";

                    echo "<table class='table table-bordered'>";

                    foreach($software as $k => $v){
                        echo "<tr><td width='46%'>".$k."</td><td>".Yii::t('app','serial_no')."</td></tr>";
                          if(!empty($v)){
                             foreach($v as $val){
                                  echo "<tr>";
                                  echo "<td style='text-indent:20px;'>".$val['name']."</td>";
                                  echo "<td>".$val['sn']."</td>";
                                  echo "</tr>";
                             }
                          }
                    }

                echo "</table>";
            }
            ?>













</div>










</div>
</div>
