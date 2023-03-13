<?php

namespace frontend\controllers;


use yii\web\ForbiddenHttpException;
use Yii;

class SettingsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if(Yii::$app->user->can('settings'))
        {
            return $this->render('index');
        }
        else
        {
            throw new ForbiddenHttpException("You have no permission to access this module.");
        }
        
    }

}
