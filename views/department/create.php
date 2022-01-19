<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Department */

$this->title = Yii::t('app','add_department');
//$this->params['breadcrumbs'][] = ['label' => 'Departments', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
