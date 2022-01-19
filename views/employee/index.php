<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use kartik\growl\Growl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchEmployee */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','employee_setting');
//$this->params['breadcrumbs'][] = $this->title;
if(Yii::$app->session->hasFlash('save')):
    echo Growl::widget([
        'type' => Growl::TYPE_SUCCESS,
        'icon' => 'glyphicon glyphicon-ok-sign',
        'title' => Yii::t('app','success_status'),
        'showSeparator' => true,
        'body' => Yii::t('app','save_success_alert')
    ]);
endif;

if(Yii::$app->session->hasFlash('delete')):
    echo Growl::widget([
        'type' => Growl::TYPE_DANGER,
        'icon' => 'glyphicon glyphicon-ok-sign',
        'title' => Yii::t('app','success_status'),
        'showSeparator' => true,
        'body' => Yii::t('app','delete_success_alert'),
    ]);
endif;
?>
<div class="employee-index">

    <div class="row">

        <div class="col-md-6">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="col-md-6">
           <div class="pull-right" style="padding-top:15px;">

                 <label>
                   <input type="checkbox" id="required_login" <?php echo $login_required == true ? 'checked' : null?> >
                   <?=Yii::t('app','required_login')?>
                </label>

          </div>
        </div>

    </div>

    <hr>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' =>['class' => 'table'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
              'attribute' => 'username',
              'visible' => $login_required == 1 ? true : false,
              'format' =>'html',
              'value' => function($model){

                  if(empty($model->username)){

                      return "<small class='text-danger'>".Yii::t('app','required_username')."</small>";

                  }else{

                      if(!empty($model->password_hash)){

                         return $model->username;

                      }else{

                        return "<small class='text-danger'>".Yii::t('app','required_password')."</small>";

                      }
                  }
              }
            ],
            'user_fullname',
            'user_position',
            'user_email',
            'user_phone',
            'department.department_name',
                [
                    'header'=>Yii::t('app','edit_delete'),
                    'class' => 'yii\grid\ActionColumn',
                    'options' => ['style' => 'width:10%;'],
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function($url, $model, $key) {

                            return Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['update','id'=>$model->id], ['class' => 'btn btn-warning btn-xs']);
                        },

                        'delete' => function($url, $model, $key) {

                            return Html::a('<i class="glyphicon glyphicon-trash"></i>',  ['delete','id'=>$model->id], [
                                        'title' => Yii::t('yii', 'Delete'),
                                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'data-method' => 'post',
                                        'data-pjax' => '0',
                                        'class' => 'btn btn-danger btn-xs'
                            ]);
                        }
                    ]
                ],
            ],
            //'layout'=>'{items}',

    ]); ?>

</div>
<?php
$this->registerJs("
	$(function(){

		$('#setting').addClass('active');

    $('#required_login').change(function(){

      if($('#required_login').is(':checked')){

          location.href='".Url::to(['employee/login-required','required'=> 1 ])."';

      } else {

          location.href='".Url::to(['employee/login-required','required'=> 0 ])."';

      }
    });


	});
");
?>
