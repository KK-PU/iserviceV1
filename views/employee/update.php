<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */

$this->title = Yii::t('app','edit_staff');

?>
<div class="employee-update">

  <h4><?= Html::encode($this->title) ?></h4>
	<hr>
    <?= $this->render('_form', [
        'model' => $model,
        'login_required' => $login_required
    ]) ?>

</div>
