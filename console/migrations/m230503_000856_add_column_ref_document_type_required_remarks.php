<?php

use yii\db\Migration;

/**
 * Class m230503_000856_add_column_ref_document_type_required_remarks
 */
class m230503_000856_add_column_ref_document_type_required_remarks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ref_document_type','required_remarks','INT(11) NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230503_000856_add_column_ref_document_type_required_remarks cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230503_000856_add_column_ref_document_type_required_remarks cannot be reverted.\n";

        return false;
    }
    */
}
