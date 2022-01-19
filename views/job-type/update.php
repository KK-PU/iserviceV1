<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\JobType */

$this->title = Yii::t('app','edit_job_type');
//$this->params['breadcrumbs'][] = ['label' => 'Job Types', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="job-type-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
