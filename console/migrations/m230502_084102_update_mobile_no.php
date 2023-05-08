<?php

use yii\db\Migration;

/**
 * Class m230502_084102_update_mobile_no
 */
class m230502_084102_update_mobile_no extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user','mobile_no','VARCHAR(10)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230502_084102_update_mobile_no cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230502_084102_update_mobile_no cannot be reverted.\n";

        return false;
    }
    */
}
