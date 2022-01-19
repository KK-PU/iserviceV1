<?php
use yii\helpers\Html;

$this->title = Yii::t('app','summary_software');
?>

  <h4 class="text-center"><?= Html::encode($this->title) ?></h4>

	<div class="container">
    <div class="pull-right" id="non-printable" style="padding-bottom:20px">

        <button class="btn btn-info btn-sm" onclick="return window.print();"><i class="glyphicon glyphicon-print"></i> <?=Yii::t('app','print')?></button>
        <button class="btn btn-default btn-sm" onclick="return window.close();"><i class="glyphicon glyphicon-off"></i> <?=Yii::t('app','close')?></button>

    </div>
		<div class="col-md-12">

			  <table class='table table-bordered'>

				<?php
				  if(!empty($result)){
            echo "<thead>";
              echo "<tr>";
                echo "<th width='15%'>Software</th>";
                echo "<th width='15%'>license</th>";
                echo "<th width='15%'>".Yii::t('app','device_type')."</th>";
                echo "<th width='25%'>".Yii::t('app','device_name')."</th>";
                echo "<th width='15%'>".Yii::t('app','department_name')."</th>";
                echo "<th width='15%'>".Yii::t('app','employee_id')."</th>";
              echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            if(!empty($result)){
              
              foreach($result as $r){

    							echo "<tr>";
    							  echo "<td>".$r['software_name']."</td>";
    							  echo "<td>".$r['sn']."</td>";
                    echo "<td>".$r['device_type']."</td>";
                    echo "<td>".$r['device_name']."</td>";
                    echo "<td>".$r['department_name']."</td>";
                    echo "<td>".$r['employee_name']."</td>";
    							echo "</tr>";
    					}

            }

          echo "</tbody>";

				  }
				?>
			  </table>

		</div>
	</div>
