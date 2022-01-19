<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Job */

$this->title = Yii::t('app','job_edit_title');
/*
$this->params['breadcrumbs'][] = ['label' => 'Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="job-update">

    <h4>
        <i class="glyphicon glyphicon-tasks"></i> 
        <?= Html::encode($this->title) ?>	
        <?php echo $job_number = !empty($model->job_number) ? Yii::t('app','job_number')." ".$model->job_number : '';?>
    </h4>
    <hr>
    <?= $this->render('_form', [
        'model' => $model,
        'start_search'=>$start_search,
        'end_search'=>$end_search,
        'page' => $page
    ]) ?>

</div>
