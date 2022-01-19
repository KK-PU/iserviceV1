<?php

/* @var $this yii\web\View */

$this->title = Yii::t('app','system_name');
?>
<div class="site-index">

    <div class="jumbotron">
        <h2><i class="glyphicon glyphicon-hdd"></i> <?=Yii::t('app','head_title')?></h2>

        <p style=" margin-bottom: 5px;"><?=Yii::t('app','head_sub')?></p>

        <div class="hidden-md hidden-lg col-sm-12">
        <p style="font-size: 18px;">
            <span style="background-color: #e7e612;">
            (<?=Yii::t('app','head_sub_list')?>)
            </span>
        </p>
        </div>


		<img src="img/projects.jpg"  class="img-responsive">
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h3><i class="glyphicon glyphicon-tasks"></i> <?=Yii::t('app','head_2')?></h3>

                <p><?=Yii::t('app','head_sub2')?></p>


            </div>
            <div class="col-lg-4">
                <h3><i class="glyphicon glyphicon-list-alt"></i> <?=Yii::t('app','head_3')?></h3>

                <p><?=Yii::t('app','head_sub3')?></p>


            </div>
            <div class="col-lg-4">
                <h3><i class="glyphicon glyphicon-file"></i> <?=Yii::t('app','head_4')?></h3>

                <p><?=Yii::t('app','head_sub4')?></p>

            </div>
        </div>

    </div>
</div>
