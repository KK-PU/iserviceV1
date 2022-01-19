<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Device */

$this->title = Yii::t('app','add_device');
/*$this->params['breadcrumbs'][] = ['label' => 'Devices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="device-create">

    <h4><i class="glyphicon glyphicon-list-alt"></i> <?= Html::encode($this->title) ?></h4>
    <hr>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
