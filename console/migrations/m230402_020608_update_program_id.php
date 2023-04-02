<?php

use yii\db\Migration;

/**
 * Class m230402_020608_update_program_id
 */
class m230402_020608_update_program_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $query = \common\models\UserData::find()
        ->joinWith('authAssignment')
        ->where(['auth_assignment.item_name' => 'OjtCoordinator'])->all();

        foreach ($query as $value) {
            $value->ref_program_id = NULL;
            $value->save(false);

            // $query2 = \common\models\UserData::find()->where(['id' => $value->id])->one();
            // $query2->ref_program_id = NULL;
            // $query2->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230402_020608_update_program_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230402_020608_update_program_id cannot be reverted.\n";

        return false;
    }
    */
}
