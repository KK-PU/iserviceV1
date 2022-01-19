<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Job */

$this->title = 'บันทึกงานซ่อม';
/*$this->params['breadcrumbs'][] = ['label' => 'Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="job-create">

    <h4><i class="glyphicon glyphicon-tasks"></i> <?= Html::encode($this->title) ?></h4>
    <hr>
    <?= $this->render('_form', [
        'model' => $model,
        
    ]) ?>

</div>
