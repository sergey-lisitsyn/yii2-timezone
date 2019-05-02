<?php
/**
 * @copyright 2019, SL
 * @version 1.0.7
 * @license MIT License
 */
namespace nikosmart\timezone;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * TimezoneDetect class.
 * 
 * @return
 * dstOffset: the offset for daylight-savings time in seconds. This will be zero 
 *      if the time zone is not in Daylight Savings Time during the specified timestamp.
 * rawOffset: the offset from UTC (in seconds) for the given location. This does 
 *      not take into effect daylight savings.
 * timeZoneId: a string containing the ID of the time zone, such as "America/Los_Angeles" 
 *      or "Australia/Sydney". These IDs are defined by Unicode Common Locale Data 
 *      Repository (CLDR) project, and currently available in file timezone.xml. 
 *      When a timezone has several IDs, the canonical one is returned. 
 *      In timezone.xml, this is the first alias of each timezone. 
 *      For example, "Asia/Calcutta" is returned, not "Asia/Kolkata".
 * timeZoneName: a string containing the long form name of the time zone. 
 *      This field will be localized if the language parameter is set. eg. 
 *      "Pacific Daylight Time" or "Australian Eastern Daylight Time"
 * status: a string indicating the status of the response.
 *    OK indicates that the request was successful.
 *    INVALID_REQUEST indicates that the request was malformed.
 *    OVER_DAILY_LIMIT indicates any of the following:
 *        The API key is missing or invalid.
 *        Billing has not been enabled on your account.
 *        A self-imposed usage cap has been exceeded.
 *        The provided method of payment is no longer valid (for example, a credit 
 *        card has expired).
 *    
 *    See the Maps FAQ to learn how to fix this.
 *    OVER_QUERY_LIMIT indicates the requestor has exceeded quota.
 *    REQUEST_DENIED indicates that the API did not complete the request. 
 *    Confirm that the request was sent over HTTPS instead of HTTP.
 *    UNKNOWN_ERROR indicates an unknown error.
 *    ZERO_RESULTS indicates that no time zone data could be found for the specified 
 *    position or time. Confirm that the request is for a location on land, 
 *    and not over water.
 * 
 * errorMessage: more detailed information about the reasons behind the given 
 *      status code, if other than OK.
 *      
 * Calculating the Local Time
 * The local time of a given location is the sum of the timestamp parameter, 
 *      and the dstOffset and rawOffset fields from the result.
 * 
 * 
 */
class TimezoneDetect extends ClientAbstract
{
    /** Default language */
    const DEFAULT_LANGUAGE = 'en';
    
    /**
     * @inheritdoc
     * @param array $config
     */
    public function __construct($config = [])
    {
        $language = (explode('-', Yii::$app->language))[0]??self::DEFAULT_LANGUAGE;
        
        $this->params = ArrayHelper::merge(
            [
                'language' => $language, // optional, defaults to 'en'
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
            "&language={$this->params['language']}" .
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
