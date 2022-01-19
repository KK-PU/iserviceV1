<?php
use yii\helpers\Html;


$this->title = Yii::t('app','import_staff');
?>
    <h4><?= Html::encode($this->title) ?></h4>
    <hr>
    <?php
        echo "<div class='well'>";

        echo "<p class='text-success'><i class='glyphicon glyphicon-ok'></i> ".Yii::t('app','import_success')."&nbsp;".$count_success."&nbsp;".Yii::t('app','items')."</p>";

        echo "<p class='text-danger'><i class='glyphicon glyphicon-remove'></i> ".Yii::t('app','import_not_success')."&nbsp;".$count_error."&nbsp;".Yii::t('app','items')."</p>";
        if($count_error > 0){

            echo '<p class="alert alert-warning">'.Yii::t('app','import_again').'&nbsp;'.Html::a(Yii::t('app','try_again'),['import/employee'],['class' => 'btn btn-default btn-xs'])."</p>";
        }

        echo "</div>";
        ?>
          <?php
              if(!empty($result)){
                  foreach($result as $r){
          ?>
              <table class="table table-bordered">
                  <tr>
                     <td colspan="2">Fullname : <?php echo $r['fullname']?>
                       <span class="text-danger">
                         <?php echo !empty($r['error'][0]['user_fullname'][0]) ? $r['error'][0]['user_fullname'][0] : NULL?>
                       </span>
                     </td>
                  </tr>
                  <tr>
                     <td width="30%">Email : <?php echo $r['email']?></td>
                     <td>Phone : <?php echo $r['phone']?></td>
                  </tr>
                  <tr>
                      <td>Position : <?php echo $r['position']?></td>
                      <td>Department : <?php echo $r['department']?><span class="text-danger"><?php echo !empty($r['error'][0]['department_id'][0]) ? $r['error'][0]['department_id'][0] : NULL?></span></td>
                  </tr>
                  <tr>
                      <td>Username : <?php echo $r['username']?><br><span class="text-danger"><?php echo !empty($r['error'][0]['username'][0]) ? $r['error'][0]['username'][0] : NULL?></span></td>
                      <td>Password : <?php echo $r['password']?></td>
                  </tr>

                  <tr>
                      <td  colspan="2"><?php echo count($r['error']) > 0 ? '<span class="text-danger"><i class="glyphicon glyphicon-remove"></i> '.Yii::t('app','import_not_success').'</span>' : '<span class="text-success"><i class="glyphicon glyphicon-ok"></i> '.Yii::t('app','import_success').'</span>'?></td>
                  </tr>
            </table>
          <?php

                  }
              }
          ?>
