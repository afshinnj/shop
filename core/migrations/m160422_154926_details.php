<?php

use yii\db\Schema;
use yii\db\Migration;

class m160422_154926_details extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%details}}', [
            'id' => Schema::TYPE_BIGPK,
            'title' => Schema::TYPE_STRING . ' not null',
            'item' => Schema::TYPE_STRING . ' not null',
            'value' => Schema::TYPE_STRING . ' not null',
            'title_id' => Schema::TYPE_INTEGER . ' not null',
            'item_id' => Schema::TYPE_INTEGER . ' not null',
            'user_id' => Schema::TYPE_INTEGER . ' not null',
            'shop_id' => Schema::TYPE_STRING . ' not null',
            'state' => Schema::TYPE_INTEGER . ' not null',
                ], $tableOptions);
    }

    public function down() {
        $this->dropTable('{{%details}}');
    }

}
