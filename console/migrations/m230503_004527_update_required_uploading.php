<?php

use yii\db\Migration;

/**
 * Class m230503_004527_update_required_uploading
 */
class m230503_004527_update_required_uploading extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $query = \common\models\DocumentType::find()->where(['id' => 5])->one();

        $query->required_remarks = 1;
        $query->update();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230503_004527_update_required_uploading cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230503_004527_update_required_uploading cannot be reverted.\n";

        return false;
    }
    */
}
