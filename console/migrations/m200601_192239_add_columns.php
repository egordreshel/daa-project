<?php

use yii\db\Migration;

/**
 * Class m200601_192239_add_columns
 */
class m200601_192239_add_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('user', 'penalty');
        $this->dropColumn('user', 'privileges');
        $this->addColumn('user', 'time', $this->integer());
        $this->createTable('prisoner_activity', [
            'id' => $this->primaryKey(),
            'prisoner_id' => $this->integer()->notNull(),
            'penalty' => $this->string()->comment('Penalty'),
            'privileges' => $this->string()->comment('Privileges')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('user', 'penalty', $this->string());
        $this->addColumn('user', 'privileges', $this->string());
        $this->dropColumn('user', 'time');
        $this->dropTable('prisoner_activity');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200601_192239_add_columns cannot be reverted.\n";

        return false;
    }
    */
}
