<?php

use yii\db\Migration;

/**
 * Class m230402_125314_add_permission_assignment
 */
class m230402_125314_add_permission_assignment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%auth_item_child}}',['parent'=>'OjtCoordinator','child'=>'view-column-course-program']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230402_125314_add_permission_assignment cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230402_125314_add_permission_assignment cannot be reverted.\n";

        return false;
    }
    */
}
