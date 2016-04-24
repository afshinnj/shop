<?php

use yii\db\Schema;
use yii\db\Migration;

class m141207_081031_init_session extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%session}}', [
            'id' => Schema::TYPE_STRING . '(40) not null PRIMARY KEY',
            'expire' => Schema::TYPE_INTEGER,
            'data' => Schema::TYPE_BINARY
                ], $tableOptions);
    }

    public function safeDown() {
        $this->dropTable('{{%session}}');
    }

}
