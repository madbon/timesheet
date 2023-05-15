<?php

use yii\db\Migration;

/**
 * Class m230515_073556_add_col_submission_thread
 */
class m230515_073556_add_col_submission_thread extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('submission_thread','date_commenced','DATE NULL');
        $this->addColumn('submission_thread','date_completed','DATE NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230515_073556_add_col_submission_thread cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230515_073556_add_col_submission_thread cannot be reverted.\n";

        return false;
    }
    */
}
