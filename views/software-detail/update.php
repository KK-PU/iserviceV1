<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SoftwareDetail */

$this->title = Yii::t('app','edit_software');
/*$this->params['breadcrumbs'][] = ['label' => 'Software Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="software-detail-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
