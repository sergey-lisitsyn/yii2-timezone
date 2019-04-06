<?php
/**
 * @copyright 2019
 * @license http://www.gnu.org/ GNU-2 License
 */
namespace nikosmart\timezone;

use Yii;
use yii\helpers\ArrayHelper;
use dosamigos\google\maps\ClientAbstract;

/**
 * TimezoneDetect class.
 */
class TimezoneDetect extends ClientAbstract
{
    
    /**
     * @inheritdoc
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->params = ArrayHelper::merge(
            [
                'timestamp' => time(),
                'lat' => null,
                'lng' => null,
            ],
            $this->params
        );
        
        parent::__construct($config);
    }
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->params['key'] = Yii::$app->params['googleTimeZoneApiKey'] ? : '';
        //$this->format = 'xml';
    }
    
    /**
     * Returns the api url
     * @return string
     */
    public function getUrl()
    {
        return "https://maps.googleapis.com/maps/api/timezone/{$this->format}?" .
            "location={$this->params['lat']},{$this->params['lng']}" .
            "&timestamp={$this->params['timestamp']}" .
            "&key=" . $this->params['key'];
    }
    
    /**
     * Makes a timezone request.
     * https://maps.googleapis.com/maps/api/timezone/json?
     *  location=38.908133,-77.047119&timestamp=1458000000&key=YOUR_API_KEY
     * @see https://developers.google.com/maps/documentation/timezone/start
     * @param array $params parameters for the request.
     *
     * @return mixed|null
     * @throws \yii\base\InvalidConfigException
     */
    public function request($params = [], $options = [])
    {
        try {
            $this->params = ArrayHelper::merge(
                $this->params,
                $params
                );
            
            $response = $this->getClient()
            ->get($this->getUrl(), $options);
            
            return $this->format == 'json'
                ? $response->json()
                : $response->xml();
                
        } catch (RequestException $e) {
            return null;
        }
    }
}
