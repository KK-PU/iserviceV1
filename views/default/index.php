<?php
use yii\helpers\Html;

$this->title = 'Backup Database';
?>

<div class="backup-default-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <hr>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>


    <div class="row">
        <div class="col-md-12">
            <?php
            echo $this->render('_list', array(
                'dataProvider' => $dataProvider
            ));
            ?>
        </div>
    </div>

</div>