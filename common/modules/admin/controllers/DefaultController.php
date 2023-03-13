<?php

namespace common\modules\admin\controllers;

use yii\web\Controller;
use common\models\ProgramMajor;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetMajor($program_id)
    {
        $query = ProgramMajor::find()
        ->where(['ref_program_id' => $program_id])
        ->all();

        if($query)
        {
            $options = '<option> -- SELECT MAJOR -- </option>';
            foreach ($query as $val) {
                $options .= "<option value='{$val->id}'>{$val->title}</option>";
            }
        }
        else
        {
            $options = '<option value="not_applicable"> -- NOT APPLICABLE -- </option>';
        }
       

        return $options;
    }

}
