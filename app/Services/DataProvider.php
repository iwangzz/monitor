<?php

namespace App\Services;

class DataProvider
{

    /**
     * convert array to object
     *
     * @param  array  $arr
     * @return object
     * @since  2017-04-11 
     */
    public function arrayToObject($arr) {
            if (gettype($arr) != 'array') {
                return;
            }
            foreach ($arr as $k => $v) {
                if (gettype($v) == 'array' || getType($v) == 'object') {
                    $arr[$k] = (object)$this->arrayToObject($v);
                }
            }
            
            return (object)$arr;
        }

    /**
     * get error report data from java api
     *
     * @param  string  $url
     * @param  array  $query
     *   $query = [
     *       'offer_id' => 12301,
     *       'level' => 2,
     *       'flag' => aff_pub,
     *       'event' => 3,
     *       'days' => 1,2,7,30,
     *       'end_date' => '2017-04-11',
     *   ]
     * @return array
     * @since  2017-06-05 
     */
    public function getBlacklist($url, $query = []) {
        $requestUrl = $url;
        $client = new \GuzzleHttp\Client();

        $res = $client->request('GET', $requestUrl, ['query' => $query]);
        $res->getBody();
        $data = json_decode($res->getBody(), true);

        if ($data['status'] == 200) {
            return $data;
        }
    }
}
