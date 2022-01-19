<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\JobType */

$this->title = Yii::t('app','add_job_type');
//$this->params['breadcrumbs'][] = ['label' => 'Job Types', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-type-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
