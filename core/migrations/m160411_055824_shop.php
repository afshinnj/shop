<?php

use yii\db\Schema;
use yii\db\Migration;

class m160411_055824_shop extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%shop}}', [
            'id' => Schema::TYPE_BIGPK,
            'shop_id' => Schema::TYPE_STRING . ' null default null',
            'user_id' => Schema::TYPE_INTEGER . ' not null',
            'title' => Schema::TYPE_STRING . ' not null',
            'name' => Schema::TYPE_STRING . ' not null',
            'email' => Schema::TYPE_STRING . ' null default null',
            'tel' => Schema::TYPE_INTEGER . ' null default null',
            'description' => Schema::TYPE_TEXT . ' null default null',
            'status' => Schema::TYPE_INTEGER . ' null default null',
            'create_time' => Schema::TYPE_DATETIME . ' null default null',
            'update_time' => Schema::TYPE_DATETIME . ' null default null',
            'ban_time' => Schema::TYPE_DATETIME . ' null default null',
            'ban_reason' => Schema::TYPE_STRING . ' null default null',
                ], $tableOptions);
    }

    public function down() {
        $this->dropTable('{{%shop}}');
    }

}
