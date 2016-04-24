<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;dbname=shop',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'tablePrefix' => 'yii_',
    'enableSchemaCache' => true,
    // Duration of schema cache.
    'schemaCacheDuration' => 3600,
    // Name of the cache component used. Default is 'cache'.
    'schemaCache' => 'DbCache',
];
