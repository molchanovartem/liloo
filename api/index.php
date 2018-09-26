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
$start = memory_get_usage();

$string = generateString(0, 1440, '1');

substr_replace($string, generateString(0, 400, '0'), 300, 700);

echo '<hr/>';

echo (memory_get_usage() - $start) / 1024;


function generateString($start = 0, $end, $symbol) {
    $str = '';
    for ($i = $start; $i < $end; $i++) $str .= $symbol;
    return $str;
}
*/

/*
$start = memory_get_usage();

$string = generateString(1440, 1);
echo $string = substr_replace($string, generateString(400, '0'), 300, 700);
//echo $string = substr_replace($string, generateString(400, '0'), 800, 1200);

echo '<hr/>';
echo strlen($string);

echo '<hr/>';

echo (memory_get_usage() - $start) / 1024;

function generateString($count, $symbol) {
    return str_pad('', $count, $symbol);
}

function replace($start, )
*/