<?php

namespace app\models;

class RequestController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
