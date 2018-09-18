<?php

namespace site\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@admin/build';

    public $css = [
        'vendors/uikit/css/uikit.css',
        'vendors/mdiIcons/css/materialdesignicons.min.css'
    ];

    public $js = [
        'vendors/uikit/js/uikit.js',
        'vendors/uikit/js/uikit-icons.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}