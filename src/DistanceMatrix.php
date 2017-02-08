<?php
/**
 * Calculate distance between two addresses using Google Distance Matrix API
 * AND/OR
 * Generate a static image with a line plotted between using Google Static Map API
 *
 * @link https://github.com/MartijnOud/DistanceMatrix
 * @version 1.2
 */
namespace MartijnOud\DistanceMatrix;

class DistanceMatrix
{

    private $key = null;

    /**
     * Construct, set the API key
     */
    public function __construct($key = 0)
    {
        $this->key = $key;
    }

    /**
     * Calculate the distance in meters between two addresses
     * Requires a valid API key with premission to use the Google Distance Matrix API
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
        if (empty($data['origins']) OR empty($data['destinations']) OR empty($this->key)) {
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

    /**
     * Generate a static image with two markers and a line plotted between
     * uses the Google Static Maps API. Make sure your $this-key has premission to use this API
     * @param array
     *        REQUIRED:
     *        origins = streetname house_nr city country
     *        destinations = streetname house_nr city country
     *        OPTIONAL:
     *        size = WIDTHxHEIGHT (default: 800x150)
     *        scale = 1,2
     *        zoom = 0-20
     *        format = png (default)
     *        maptype =  roadmap (default), satellite, terrain, hybrid
     * @return string image url OR false
     */
    public function map($data = array())
    {

        // Required variables
        if (empty($data['origins']) OR empty($data['destinations'])) {
            trigger_error("Not all required parameters are set", E_USER_ERROR);
            exit();
        }

        // Set the default variables
        if (empty($data['size'])) {
            $data['size'] = "800x150";
        }


        $url = "https://maps.googleapis.com/maps/api/staticmap?markers=".urlencode($data['origins'])."|".urlencode($data['destinations'])."&path=".urlencode($data['origins'])."|".urlencode($data['destinations'])."&size=".$data['size'];

        // Only add these values if specifically set
        if (!empty($this->key)) {
            $url .= "&key=".$this->key;
        }

        if (!empty($data['scale'])) {
            $url .= "&scale=".$data['scale'];
        }

        if (!empty($data['zoom'])) {
            $url .= "&zoom=".$data['zoom'];
        }

        if (!empty($data['format'])) {
            $url .= "&format=".$data['format'];
        }

        if (!empty($data['maptype'])) {
            $url .= "&maptype=".$data['maptype'];
        }

        if (@!getimagesize($url)) {
            return false;
        } else {
            return $url;
        }
    }

    /**
     * Make a call to $url and download its contents with cURL
     * @param string $url
     * @return json_decoded contents of $url
     */
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