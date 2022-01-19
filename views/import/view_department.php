<?php
use yii\helpers\Html;

$this->title = Yii::t('app','import_department');

?>

<h4><?= Html::encode($this->title) ?></h4>
<hr>

  <?php
      echo "<div class='well'>";
      echo "<p class='text-success'><i class='glyphicon glyphicon-ok'></i> ".Yii::t('app','import_success')."&nbsp;".$count_success."&nbsp;".Yii::t('app','items')."</p>";

      echo "<p class='text-danger'><i class='glyphicon glyphicon-remove'></i> ".Yii::t('app','import_not_success')."&nbsp;".$count_error."&nbsp;".Yii::t('app','items')."</p>";
        if($count_error > 0){
            echo '<p class="alert alert-warning">'.Yii::t('app','import_again').'&nbsp;'.Html::a(Yii::t('app','try_again'),['import/department'],['class' => 'btn btn-default btn-xs'])."</p>";
        }
      echo "</div>";
  ?>

        <table class="table table-bordered">
            <tr class="active">
                <th width="80%"><?=Yii::t('app','department_name')?></th>
                <th width="20%"><?=Yii::t('app','import_result')?></th>
            </tr>
          <?php
              if(!empty($result)){
                  foreach($result as $r){
          ?>
                      <tr>
                          <td>  <?php echo $r['id']?>
                            <?php echo $r['department']?>
                                <span class="text-danger">
                                    <?php echo !empty($r['error'][0]['department_name'][0]) ? $r['error'][0]['department_name'][0] : NULL?>
                                </span>
                          </td>
                          <td><?php echo count($r['error']) > 0 ? '<span class="text-danger"><i class="glyphicon glyphicon-remove"></i> '.Yii::t('app','import_not_success').'</span>' : '<span class="text-success"><i class="glyphicon glyphicon-ok"></i> สำเร็จ</span>'?></td>
                      </tr>
          <?php
                  }
              }
          ?>
        </table>
