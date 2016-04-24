<?php

use app\modules\User\models\User;
use yii\db\Schema;
use yii\db\Migration;

class m160314_083311_user extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_BIGPK,
            'role_id' => Schema::TYPE_STRING . ' not null',
            'status' => Schema::TYPE_SMALLINT . ' not null',
            'email' => Schema::TYPE_STRING . ' null default null',
            'username' => Schema::TYPE_STRING . ' null default null',
            'password' => Schema::TYPE_STRING . '(60) null default null',
            'password_salt' => Schema::TYPE_STRING . '(60) null default null',
            'auth_key' => Schema::TYPE_STRING . ' null default null',
            'login_ip' => Schema::TYPE_STRING . '(15) null default null',
            'login_time' => Schema::TYPE_DATETIME . ' null default null',
            'create_time' => Schema::TYPE_DATETIME . ' null default null',
            'update_time' => Schema::TYPE_DATETIME . ' null default null',
            'ban_time' => Schema::TYPE_DATETIME . ' null default null',
            'ban_reason' => Schema::TYPE_STRING . ' null default null',
                ], $tableOptions);

        $this->createTable('{{%profile}}', [
            'id' => Schema::TYPE_BIGPK,
            'user_id' => Schema::TYPE_INTEGER . ' not null',
            'create_time' => Schema::TYPE_DATETIME . ' null default null',
            'update_time' => Schema::TYPE_DATETIME . ' null default null',
            'full_name' => Schema::TYPE_STRING . ' null default null',
            "mobile" => Schema::TYPE_STRING . '(40) null default null',
            "avatar" => Schema::TYPE_STRING . '(100) null default null',
                ], $tableOptions);


        $this->addForeignKey('{{%profile_user_id}}', '{{%profile}}', 'user_id', '{{%user}}', 'id');


        // insert admin user: neo/neo
        $security = Yii::$app->security;
        $columns = ['role_id', 'email', 'username', 'password', 'status', 'create_time', 'auth_key'];
        $this->batchInsert('{{%user}}', $columns, [
            [
                'admin',
                'neo@neo.com',
                'neo',
                '$2y$13$dyVw4WkZGkABf2UrGWrhHO4ZmVBv.K4puhOL59Y9jQhIdj63TlV.O',
                User::STATUS_ACTIVE,
                Yii::$app->jdate->date('Y-m-d H:i:s'),
                $security->generateRandomString(),
            ],
        ]);
    }

    public function down() {

        $this->dropTable('{{%profile}}');
        $this->dropTable('{{%user}}');
    }

}
