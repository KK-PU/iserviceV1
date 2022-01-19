<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Employee */

$this->title = Yii::t('app','add_staff');
//$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-create">

  <h4><?= Html::encode($this->title) ?></h4>
  <hr>

    <?= $this->render('_form', [
        'model' => $model,
        'login_required' => $login_required
    ]) ?>

</div>
