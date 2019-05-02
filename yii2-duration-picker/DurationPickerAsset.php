<?php

namespace nikosmart\duration;

use yii\web\AssetBundle;

/**
 * Class DurationAsset
 * @package nikosmart\duration
 */
class DurationPickerAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath;

    /**
     * @inheritdoc
     */
    public $js = [
        'js/bootstrap-duration-picker.js'
    ];

    /**
     * @inheritdoc
    */
    public $css = [
        'css/bootstrap-duration-picker.css'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';
        parent::init();
    }
}