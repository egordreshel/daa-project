<?php

use yii\db\Migration;

/**
 * Class m200526_175506_add_columns_in_zone
 */
class m200526_175506_add_columns_in_zone extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('zone', 'region_id', $this->integer());
        $this->addForeignKey('zone_region_id_fkey', 'zone', 'region_id', 'region', 'id', 'CASCADE', 'CASCADE');
        $this->addColumn('region', 'status', $this->integer());
        $this->addColumn('user', 'region_id', $this->integer());
        $this->addForeignKey('user_region_id_fkey', 'user', 'region_id', 'region', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('region', 'status');
        $this->dropForeignKey('zone_region_id_fkey', 'zone');
        $this->dropColumn('zone', 'region_id');
        $this->dropForeignKey('user_region_id_fkey', 'user');
        $this->dropColumn('user', 'region_id');
    }
}
