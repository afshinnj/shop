<?php

use yii\db\Schema;
use yii\db\Migration;

class m160419_195945_products extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product}}', [
            'id' => Schema::TYPE_BIGPK,
            'shop_id' => Schema::TYPE_STRING . ' not null',
            'item_id' => Schema::TYPE_INTEGER . ' not null',
            'user_id' => Schema::TYPE_INTEGER . ' not null',
            'title' => Schema::TYPE_STRING . ' not null',
            'description' => Schema::TYPE_TEXT . ' null default null',
            'detail' => Schema::TYPE_TEXT . ' null default null',
            'price' => Schema::TYPE_STRING . ' null default null',
            'create_time' => Schema::TYPE_DATETIME . ' null default null',
            'update_time' => Schema::TYPE_DATETIME . ' null default null',
                ], $tableOptions);

        $this->createTable('{{%product_image}}', [
            'id' => Schema::TYPE_PK,
            'product_id' => Schema::TYPE_INTEGER . ' not null',
            'address' => Schema::TYPE_STRING . ' not null',
                ], $tableOptions);
    }

    public function down() {
        $this->dropTable('{{%product}}');
        $this->dropTable('{{%product_image}}');
    }

}
