<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SoftwareType */

$this->title = Yii::t('app','add_software_type');
/*
$this->params['breadcrumbs'][] = ['label' => 'Software Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="software-type-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
