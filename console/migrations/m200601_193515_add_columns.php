<?php

use yii\db\Migration;

/**
 * Class m200601_193515_add_columns
 */
class m200601_193515_add_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('prisoner_activity_prisoner_id_fkey', 'prisoner_activity', 'prisoner_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('prisoner_activity_prisoner_id_fkey', 'prisoner_activity');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200601_193515_add_columns cannot be reverted.\n";

        return false;
    }
    */
}
