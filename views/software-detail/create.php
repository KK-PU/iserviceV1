<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SoftwareDetail */

$this->title = Yii::t('app','add_software');
/*$this->params['breadcrumbs'][] = ['label' => 'Software Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="software-detail-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
