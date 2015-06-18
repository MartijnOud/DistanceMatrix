<?php
/**
 * Calculate distance between two addresses using Google Distance Matrix API
 *
 * @link https://github.com/MartijnOud/DistanceMatrix
 * @version 1.0.0 Initial release
 */
namespace MartijnOud;

class DistanceMatrix
{

    private $key = null;

    /**
     * Construct, set the API key
     */
    public function __construct($key = 0)
    {
        if (empty($key)) {
            trigger_error("No API key set", E_USER_ERROR);
            exit(); 
        }

        $this->key = $key;
    }

    /**
     * Calculate the distance in meters between two addresses
     * @param array
     *        REQUIRED:
     *        origins = streetname house_nr city country
     *        destinations = streetname house_nr city country
     *        OPTIONAL:
     *        mode = driving, walking, bicycling
     *        language = en-GB, nl, de, etc
     * @return int distance in meters OR false
     */
    public function distance($data = array())
    {   
        // Prepare API call
        // Set default variables
        if (empty($data['mode'])) {
            $data['mode'] = "driving";
        }

        if (empty($data['language'])) {
            $data['language'] = "en-GB";
        }

        // Required variables
        if (empty($data['origins']) OR empty($data['destinations'])) {
            trigger_error("Not all required parameters are set", E_USER_ERROR);
            exit();
        }

        $strUrl = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".urlencode($data['origins'])."&destinations=".urlencode($data['destinations'])."&mode=".$data['mode']."&language=".$data['language']."&key=".$this->key;
        $response = $this->call($strUrl);

        if ($response->status == "OK") {
            return $response->rows[0]->elements[0]->distance->value;
        } else {
            return false;
        }

    }

    private function call($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        return json_decode($response);
    }
}