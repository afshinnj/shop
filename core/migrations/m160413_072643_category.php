<?php

use yii\db\Schema;
use yii\db\Migration;

class m160413_072643_category extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%categorys}}', [
            'id' => Schema::TYPE_BIGPK,
            'group' => Schema::TYPE_STRING . ' not null',
            'category' => Schema::TYPE_STRING . ' not null',
            'item' => Schema::TYPE_STRING . ' not null',
            'group_id' => Schema::TYPE_INTEGER . ' not null',
            'category_id' => Schema::TYPE_INTEGER . ' not null',
            'shop_id' => Schema::TYPE_STRING . ' not null',
            'user_id' => Schema::TYPE_INTEGER . ' not null',
            'state' => Schema::TYPE_INTEGER . ' not null',
                ], $tableOptions);
    }

    public function down() {
        $this->dropTable('{{%categorys}}');
    }

}
