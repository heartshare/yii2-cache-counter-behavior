<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../vendor/yiisoft/yii2/yii/Yii.php');

$config = array(
    'id' => 'bootstrap',
    'basePath' => dirname(__DIR__),
    'components' => [
        'db' => [
            'class'             => 'yii\db\Connection',
            'dsn'               => 'mysql:host=localhost;dbname=Yii2CacheCounterBehavior',
            'emulatePrepare'    => true,
            'username'          => 'root',
            'password'          => '1',
            'charset'           => 'utf8',
            'enableSchemaCache' => true
        ]
    ],
    'params' => [],
);

$application = new yii\web\Application($config);