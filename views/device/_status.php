<?php
use yii\helpers\Html;
use app\models\Device;
?>
    <div class="row">
        <div class="col-md-12">

		          <?= Yii::$app->user->identity->role == 'admin' ? Html::button(Yii::t('app', 'delete_all_select'), ['class' => 'btn btn-warning btn-xs','id'=>'btn-delete']) : null ?>

            <div class="pull-right">
                <?= Html::a('<i class="glyphicon glyphicon-ok-sign"></i> '.Yii::t('app','normal').' <span class="badge">'.number_format(Device::countStatus('enable')).'</span>',['device-status','status'=>'enable'])?>
                <?= Html::a('<i class="glyphicon glyphicon-remove-sign"></i> '.Yii::t('app','fixing').' <span class="badge">'.Device::countStatus('repair').'</span>',['device-status','status'=>'repair'])?>
                <?= Html::a('<i class="glyphicon glyphicon-remove-sign"></i> '.Yii::t('app','deprecated').' <span class="badge">'.Device::countStatus('disable').'</span>',['device-status','status'=>'disable'])?>
                <?= Html::a('<i class="glyphicon glyphicon-info-sign"></i> '.Yii::t('app','total').' <span class="badge">'.number_format(Device::find()->count()).'</span>',['device-status','status'=>'total'])?>
            </div>
        </div>
    </div>
<?php
$this->registerCss("
        a{
            color:#000;
        }
");
?>
