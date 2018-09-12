<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL); // E_ALL & ~E_NOTICE

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../common/vendor/autoload.php');
require(__DIR__ . '/../common/vendor/yiisoft/yii2/Yii.php');

$config = array_merge_recursive(
    require(__DIR__ . '/../common/config/config.php'),
    require(__DIR__ . '/config/main.php')
);
$app = new \yii\web\Application($config);
$app->run();

/*
Yii::$app->account->getId();
Yii::$app->account->getBalance();
Yii::$app->account->getTarifs();

new ValidateTarifs(Yii::$app->account->getTarifs());


// createMaster

$this->on('beforeCreate', function () {
    $validateTarif->beforeCreate();
    Yii::$app->validateTarif->master->beforeCreate();

    \yii\log\Logger::class;
    \yii\log\Logger::class;
    \yii\log\Logger::class;
    \yii\log\Logger::class;
    \yii\log\Logger::class;
    \yii\log\Logger::class;
    \yii\log\Logger::class;
});

$this->on('beforeView', function () {
    $validateTarif->beforeView();
});


class MasterValidateTarif
{
    const MASTER_CREATE = 'm1';
    const MASTER_UPDATE = 'm2';


    public function execute($event)
    {

    }


    public function beforeCreate()
    {
     if (ismaster) {
         $this->createMaster();
         $this->createMasterForOne();
     } else {
         $this->createMaster();
         $this->createMasterForOne();
     }
    }

    public function beforeView()
    {
        if (ismaster) {
            $this->createMaster();
            $this->createMasterForOne();
        } else {
            $this->createMaster();
            $this->createMasterForOne();
        }
    }
}


$this->trigger('beforeCreate');

$this->trigger('create');

//$this->trigger('afterCreate');

$tarifs = [
    ['name' => 'main', 'code' => [1, 2, 3, 4, 5, 6, 7, 8, 98]],
    ['name' => 'common', 'code' => [30, 20, 10, 5]]
];


foreach ()
*/