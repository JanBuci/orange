<?php

namespace App\Http\Controllers;

use App\Models\OrderBook;
use Illuminate\Http\Request;

class OrderBookController extends Controller
{
    /**
     * fill DB table with fresh data from API
     * @return void
     */
    public function fillOrderBook()
    {
        $data = $this->getDataFromAPI();
        if ($data) {
            $this->saveDataToDB($data);
        }else{
            // Handle Errors
        }
    }

    /**
     * make API call and return data
     * @return null
     */
    private function getDataFromAPI(){

        $opts = stream_context_create(array('http' =>
            array(
                'timeout' => env('API_TIMEOUT')
            )
        ));
        $json = json_decode(file_get_contents(env('API_URL'), true,$opts));
        return $json->result ? : null;
    }

    /**
     * execute mass insert to DB
     * @param $json
     * @return void
     */
    private function saveDataToDB($json){
        $data = $this->transformData($json);
        OrderBook::insert($data);
    }

    /**
     * parse data from json to data table structure
     * @param $data
     * @return array
     */
    private function transformData($data)
    {
        $dataArray = array();
        $i=0;
        $valuePair = str_split(env('API_CURRENCY_PAIR'), 3);
        foreach ($data->{key($data)} as $key => $val) {
            foreach ($val as $item) {
                $dataArray[$i]['cena'] = $item[0];
                $dataArray[$i]['zdrojova_mena'] = $valuePair[0];
                $dataArray[$i]['cielova_mena'] = $valuePair[1];
                $dataArray[$i]['priznak'] = $key;
                $dataArray[$i]['casova_peciatka'] = date('Y-m-d H:i:s',$item[2]);
                $i++;
            }
        }
        return $dataArray;
    }

}
