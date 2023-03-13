<?php

namespace common\components;

use yii\base\Widget;
use yii\grid\GridView;

class PdfWidget extends Widget
{
    public $dataProvider;

    public function run()
    {
        $content = GridView::widget([
            'dataProvider' => $this->dataProvider,
            'columns' => [
                // define your columns here
            ],
        ]);

        return $content;
    }
}
