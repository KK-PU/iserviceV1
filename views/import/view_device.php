<?php
use yii\helpers\Html;

$this->title = Yii::t('app','import_device');

?>

<h4><?= Html::encode($this->title) ?></h4>
<hr>

  <?php
      echo "<div class='well'>";

      echo "<p class='text-success'><i class='glyphicon glyphicon-ok'></i> ".Yii::t('app','import_success')."&nbsp;".$count_success."&nbsp;".Yii::t('app','items')."</p>";

      echo "<p class='text-danger'><i class='glyphicon glyphicon-remove'></i> ".Yii::t('app','import_not_success')."&nbsp;".$count_error."&nbsp;".Yii::t('app','items')."</p>";
      if($count_error > 0){

          echo '<p class="alert alert-warning">'.Yii::t('app','import_again').'&nbsp;'.Html::a(Yii::t('app','try_again'),['import/device'],['class' => 'btn btn-default btn-xs'])."</p>";
      }

      echo "</div>";


if(!empty($result)){

		foreach($result as $r){

			echo "<table class='table table-bordered'>";

			echo "<tr>";

				  $device_id_error = !empty($r['error']['device_id'][0]) ? "<small class='text-danger'>".$r['error']['device_id'][0]."</small>" : NULL;

					echo "<td>Device ID : ".$r['device_id']."<br>".$device_id_error;
					echo "</td>";
					echo "<td>Serial Number :".$r['serial_no']."</td>";
					echo "<td>Brand : ".$r['device_brand']."</td>";
			echo "</tr>";

			echo "<tr>";
					echo "<td> Model : ".$r['device_model']."</td>";
					echo "<td> Device Name : ".$r['device_name']."</td>";
					echo "<td> Memory : ".$r['memory']."</td>";
		  echo "</tr>";

			echo "<tr>";
					echo "<td> Cpu : ".$r['cpu']."</td>";
					echo "<td> Hardisk : ".$r['harddisk']."</td>";
					echo "<td> Monitor : ".$r['monitor']."</td>";
		  echo "</tr>";

			echo "<tr>";
					echo "<td> Mouse : ".$r['mouse']."</td>";
					echo "<td> Keyboard : ".$r['keyboard']."</td>";
					echo "<td> External Drive : ".$r['ex_drive']."</td>";
			echo "</tr>";

			echo "<tr>";
					echo "<td> Hardware Other : ".$r['hardware_other']."</td>";
					echo "<td> Ip : ".$r['device_ip']."</td>";
					echo "<td> Mac Address : ".$r['mac']."</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td> Date Use  : ".$r['date_use'];
					echo !empty($r['error']['date_use'][0]) ? "&nbsp;<small class='text-danger'>".$r['error']['date_use'][0]."</small>" : NULL;
				echo "</td>";
				echo "<td> Date Expire : ".$r['date_expire'];

				echo !empty($r['error']['date_expire'][0]) ? "&nbsp;<small class='text-danger'>".$r['error']['date_expire'][0]."</small>" : NULL;
				echo "</td>";
				echo "<td> Price : ".$r['device_price']."</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td> Vendor : ".$r['vender']."</td>";
				echo "<td> Warranty : ".$r['warranty']."</td>";
				echo "<td> Status : ".$r['device_status']."</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td> Other Detail : ".$r['other_detail']."</td>";
				echo "<td> Device Type : ".$r['device_type']."</td>";
				echo "<td> Department Name : ".$r['depatment_name']."</td>";

			echo "</tr>";

			echo "<tr>";
							echo "<td colspan='3'> Employee : ".$r['employee_id']."</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td colspan='3'>";
				 		echo count($r['error']) > 0 ? '<span class="text-danger"><i class="glyphicon glyphicon-remove"></i> ไม่สามารถนำเข้าข้อมูลได้</span>' : '<span class="text-success"><i class="glyphicon glyphicon-ok"></i> สำเร็จ</span>';
			  echo "</td>";
			echo "</tr>";

			echo "</table>";
		}
}
?>
