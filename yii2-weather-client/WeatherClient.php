<?php
/**
 * @copyright Copyright (c) 2017
 * @link
 * @license http://www.gnu.org/ GNU-2 License
 */
namespace nikosmart\weather;


use Yii;
use dosamigos\google\maps\ClientAbstract;
use yii\helpers\ArrayHelper;
use GuzzleHttp\Exception\RequestException;

/**
 * WeatherClient
 *
 * @author Sergey Lisitsyn <sergej.lisitsyn@gmail.com>
 */
class WeatherClient extends ClientAbstract
{
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
            $this->params
        );
        
        parent::__construct($config);
    }
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->params['key'] = @Yii::$app->params['wundergroundApiKey'] ? : null;
    }

    /**
     * Returns the api url
     * @return string
     */
    public function getUrl()
    {
        return "http://api.wunderground.com/api/" . $this->params['key'] .
            "/conditions/lang:{$this->params['lang']}".
            "/q/{$this->params['lat']},{$this->params['lng']}.{$this->format}";
    }

    /**
     * Makes a weather request.
     * https://www.wunderground.com/weather/api/d/docs?d=autocomplete-api
     *
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