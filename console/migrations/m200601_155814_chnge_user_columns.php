<?php

use yii\db\Migration;

/**
 * Class m200601_155814_chnge_user_columns
 */
class m200601_155814_chnge_user_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user','token',$this->string()->comment('Identity number'));
        $this->dropColumn('user','status');
        $this->addColumn('user','penalty',$this->string());
        $this->addColumn('user','privileges', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200601_155814_chnge_user_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200601_155814_chnge_user_columns cannot be reverted.\n";

        return false;
    }
    */
}
