<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SoftwareType */

$this->title = Yii::t('app','edit_software_type');
/*
$this->params['breadcrumbs'][] = ['label' => 'Software Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="software-type-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
