<?php

use yii\db\Migration;

/**
 * Class m230401_054400_another_permission
 */
class m230401_054400_another_permission extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%auth_item}}',['name'=>'view-column-course-program','type'=>'2','description'=> NULL,'rule_name'=>NULL,'data'=>NULL,'created_at'=>NULL,'updated_at'=>NULL]);
        $this->insert('{{%auth_item_child}}',['parent'=>'Administrator','child'=>'view-column-course-program']);
        $this->insert('{{%auth_item_child}}',['parent'=>'CompanySupervisor','child'=>'view-column-course-program']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230401_054400_another_permission cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230401_054400_another_permission cannot be reverted.\n";

        return false;
    }
    */
}
