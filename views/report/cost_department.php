<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\models\Job;
use kartik\select2\Select2;

$this->title = Yii::t('app','sum_maintenance');
?>

<h4><?= Html::encode($this->title) ?></h4>

<?= $this->render('_menu', ['active' => 'cost']); ?>
<br>
<div class="row">
<?php
    $form = ActiveForm::begin([
                'action' => ['cost-department'],
                'method' => 'get',
                'options' => ['class' => 'form-inline'],
            ]);
    ?>
    <div class="col-md-3">
        <div class="form-group">
              <?php
                    echo Select2::widget([
                    'name' => 'month',
                    'data' => Job::itemsAlias('month'),
                    'value'=>$month,
                      'hideSearch'=>true,
                    'options' => [
                        'placeholder' => Yii::t('app','month'),

                        ],
                    'addon' => [
                        'prepend' => [
                            'content' => '<i class="glyphicon glyphicon-search"></i>',
                        ],
                    ]
                    ]);
                ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <?php
                echo Select2::widget([
                    'name' => 'year',
                    'data' => Job::itemsAlias('year'),
                    'value'=>$year,
                    'hideSearch'=>true,
                    'options' => [
                        'placeholder' => Yii::t('app','year'),

                        ],

                    'addon' => [
                        'prepend' => [
                            'content' => '<i class="glyphicon glyphicon-search"></i>',
                        ],
                    ]
                    ]);
                ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> '.Yii::t('app','search'), ['class' => 'btn btn-success btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<br>
    <table class="table table-bordered report-table">
        <tr class="cost-table">
            <th width="5%" style="text-align:center;"><?=Yii::t('app','order')?></th>
            <th width="75%" ><?=Yii::t('app','department_name')?></th>
            <th width="10%" style="text-align:center;"><?=Yii::t('app','maintenance_fee')?></th>
            <th width="15%" style="text-align:center;"><?=Yii::t('app','detail')?></th>
        </tr>
        <?php
		    $sum = 0;

            if (!empty($data)) {
                $i = 1;

                foreach ($data as $cost) {
                    echo "<tr>";
                    echo"<td class='text-center'>" . $i . "</td>";
                    echo "<td>" . $cost['department_name'] . "</td>";
                    echo "<td align='right'>".number_format($cost['price'],2)."</td>";
                    echo "<td align='center'>" . Html::a(Yii::t('app','detail'), [
                        'detail-cost',
                        'month' => $month,
                        'year' => $year,
                        'department_id' => $cost['department_id']
                            ], ['target' => '_blank']) . "</td>";
                    echo "</tr>";
                    $i++;
                    $sum += $cost['price'];
                }
            } else {
                echo "<tr>
                        <td colspan='4'>".Yii::t('app','data_not_found')."</td>
                     </tr>";
                $sum = 0;
            }
        ?>
    </table>

<p><?=Yii::t('app','total_all')?>  <?php echo number_format($sum,2)?>  <?=Yii::t('app','bath')?></p>
