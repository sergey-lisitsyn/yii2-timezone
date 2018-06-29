<?php

namespace nikosmart\duration;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * @package   yii2-duration-picker
 * @author    Sergey Lisitsyn <sergej.lisitsyn@gmail.com>
 * @copyright Copyright &copy; Sergey Lisitsyn, Nikosmart, 2017
 * @version   1.0.0
 */
class DurationPicker extends InputWidget
{
    
    /**
     * @inheritdoc
     */
    public $pluginName = 'durationpicker';
    
    /**
     * @var array HTML attributes for the input group container
     */
    public $containerOptions = [];
    
    /**
     * the DurationPicker JQuery plugin options
     * @var array
     */
    public $pluginOptions = [];
    
    /**
     * @var string
     */
    protected $formId;
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->formId = Html::getInputId($this->model, $this->attribute);
        $this->value = Html::getAttributeValue($this->model, $this->attribute);
        $this->preparePluginOptions();
        $this->registerAssets();
        echo Html::tag('div', $this->renderInput(), $this->containerOptions);
    }
    
    /**
     * Renders the input
     *
     * @return string
     */
    protected function renderInput()
    {
        Html::addCssClass($this->options, 'form-control');
        
        return Html::textInput(Html::getInputName($this->model, $this->attribute),
            $this->value, $this->options);
    }
    
    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        
        DurationPickerAsset::register($view);
        $view->registerJs("jQuery('#{$this->formId}').durationPicker({$this->pluginOptions});");
    }
    
    /**
     * Preparing arrays options to json format.
     */
    protected function preparePluginOptions()
    {
        $this->pluginOptions = ArrayHelper::merge($this->pluginOptions,
            ['translations' => $this->localization()]);
        $this->pluginOptions = Json::encode($this->pluginOptions);
    }
    
    /**
     * 
     */
    protected function localization()
    {
        return [
            'day' => Yii::t('main', 'day'),
            'hour' => Yii::t('main', 'hour'),
            'minute' => Yii::t('main', 'minute'),
            'second' => Yii::t('main', 'second'),
            'days' => Yii::t('main', 'days'),
            'hours' => Yii::t('main', 'hours'),
            'minutes' => Yii::t('main', 'minutes'),
            'seconds' => Yii::t('main', 'seconds')
        ];
    }
}