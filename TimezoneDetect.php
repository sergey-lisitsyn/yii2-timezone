<?php

namespace nikosmart\timezone;

use yii\helpers\ArrayHelper;
use yii\base\BaseObject;

/**
 * TimezoneDetect class.
 */
class TimezoneDetect extends BaseObject
{
    
    /** @var array the request parameters */
    public $params = [];
    
    private $_hours;
    
    private $_minutes;
    
    /**
     * @inheritdoc
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->params = ArrayHelper::merge(
            [
                'lang' => null,
                'lat' => null,
                'lng' => null,
            ],
            $config
        );
    }
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->params['key'] = @Yii::$app->params['googleMapsApiKey'] ? : null;
    }
    
    public function getHours()
    {
        return $this->_hours;
    }
    
    public function getMinutes()
    {
        return $this->_minutes;
    }
    
    /**
     * @return \nikosmart\timezone\TimezoneDetect
     */
    public function getTimeByCoords()
    {
        $this->_hours = 0;
        $this->_minutes = 0;
        
        return $this;
    }
}
