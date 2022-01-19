<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dektrium\user\models\User;
use app\models\Job;
use app\models\Device;

$this->title = Yii::t('app','summary_software');
?>

<h4><i class="glyphicon glyphicon-stats"></i> <?= Html::encode($this->title) ?></h4>

  <?=$this->render('_menu',['active'=>'software_report']);?>

  <br>

    <div class="col-md-12">

      <h4 class="text-center"><?=Yii::t('app','summary_software')?></h4>

		<div class="pull-right" style="padding-bottom:20px;">
			<?=Html::a("<i class='glyphicon glyphicon-print'></i> ".Yii::t('app','print'),['software-report','print'=> 'print'],['class'=>'btn btn-default btn-sm','target'=>'_blank'])?>
	    </div>

          <table class='table table-bordered'>
            <?php
              if(!empty($software)){

                foreach($software as $k => $v){
                    echo "<tr class='active'>";

                    echo "<th width='60%'>".$k."</th>";
                    echo "<th class='text-center'>".Yii::t('app','software_sn_install')."</th>";
                    echo "<th class='text-center'>".Yii::t('app','software_install')."</th>";
                    echo "<th class='text-center'>".Yii::t('app','detail')."</th>";
                    echo "</tr>";
                      foreach($v as $s){
                        echo "<tr>";
                          echo "<td style='text-indent:30px;'>".$s['software_name']."</td>";
                          echo "<td class='text-center'>".$s['total_sn']."</td>";
                          echo "<td class='text-center'>".$s['total_install']."</td>";
                          echo "<td class='text-center'>".Html::a(Yii::t('app','detail'),['software-report-detail','software_id' => $s['id']],['target' => '_blank'])."</td>";
                        echo "</tr>";
                      }
                  //  echo $v['total'];
                }

              }
            ?>
          </table>
    </div>
