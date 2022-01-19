<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DeviceType */

$this->title = Yii::t('app','add_device_type');
//$this->params['breadcrumbs'][] = ['label' => 'Device Types', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-type-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
