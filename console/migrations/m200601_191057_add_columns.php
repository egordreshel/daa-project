<?php

use yii\db\Migration;

/**
 * Class m200601_191057_add_columns
 */
class m200601_191057_add_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user', 'username', $this->string()->unique());
        $this->alterColumn('user', 'auth_key', $this->string(32));
        $this->alterColumn('user', 'password_hash', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200601_191057_add_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200601_191057_add_columns cannot be reverted.\n";

        return false;
    }
    */
}
