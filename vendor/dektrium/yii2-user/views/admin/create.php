<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\Html;

/**
 * @var yii\web\View 				$this
 * @var dektrium\user\models\User 	$user
 */
/*
$this->title = Yii::t('user', 'Create a user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
*/


$this->title = Yii::t('user', 'ตั้งค่าบัญชีผู้ใช้ระบบ : เพิ่มผู้ใช้งานระบบ');
?>
 <h4><?= Html::encode($this->title) ?></h4>
<hr>

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-default">
			<div class="panel-heading"> เพิ่มผู้ใช้งานระบบ</div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'layout' => 'horizontal',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'fieldConfig' => [
                        'horizontalCssClasses' => [
                            'wrapper' => 'col-sm-9',
                        ],
                    ],
                ]); ?>

                <?= $this->render('_user', ['form' => $form, 'user' => $user]) ?>

             
						<div class="row">
							<div class="col-md-12">
								<div class="pull-right">
								<?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-success']) ?>
								<?= Html::a('ยกเลิก',['admin/index'],['class'=>'btn btn-default']);?>
							</div>
						</div>
					</div>
                

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
