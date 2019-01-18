<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    private $obapiurl = 'http://search.onboard-apis.com', $obapikey = '17644c3fd3774717b469fb3d146d4a92';


    public function getzipResponse(Request $request)
    {
        $address = $request->input('address');
        $location = $request->input('location');
        $zip= $request->input('zip');
        $AreaHierarchy = $this->getAreaHierarchy($location[0],$location[1]);
        $geoARRAY = array();
        $geoValName = array();
        foreach ($AreaHierarchy['response']['result']['package']['item'] as $key => $area) {
            $geoARRAY[]  = $area['geo_key'];
            $geoValName[$area['geo_key']] = $area['name'];
        }
        $boundary = $this->getAreaBoundary($geoARRAY[0]);
        return response($boundary['response']['result']['package']['item'][0]['boundary']);
    }
    public function test()
    {
        return view('test');
    }

    public function allpropertiesList(Request $request)
    {
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $page = $request->input('page');
        $zip = $request->input('zip');
        $zip = urlencode($zip);
        $pagesize = 1000;
        $url = $this->obapiurl . '/propertyapi/v1.0.0/property/detail?latitude=' . $lat . '&longitude=' . $lng . '&page=' . $page . '&pagesize=' . $pagesize ;
        //$url = $this->obapiurl . '/propertyapi/v1.0.0/property/detail?postalcode=' . $zip . '&page=' . $page . '&pagesize=' . $pagesize;
        $result = $this->curlPOIAPI($url);
        return response($result);
    }

    public function getTotalPages(Request $request)
    {
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $pagesize = 1;
        $page = 1;
        $url = $this->obapiurl . '/propertyapi/v1.0.0/property/address?latitude=' . $lat . '&longitude=' . $lng . '&page=' . $page . '&pagesize=' . $pagesize;
        $result = $this->curlPOIAPI($url);
        $total = $result['status']['total'];
        $totalPages = $total / 1000;
        return response($totalPages);
    }
    public function getPropertyResponse(Request $request)
    {
        $address = $request->input('address');

        $propertyInfo = $this->getPropertyDetail($address);
        return response($propertyInfo["property"][0]["summary"]["legal1"]);
    }


    private function getPropertyDetail($address){
        $address = urlencode($address);
        $url = $this->obapiurl . '/propertyapi/v1.0.0/property/detail?address='.$address;
        return $this->curlPOIAPI($url);
    }
    private function getAreaHierarchy($lat,$long){
        $location = urlencode($long.','.$lat);
        $url = $this->obapiurl . "/areaapi/v2.0.0/hierarchy/lookup?WKTString=POINT(" . $location. ")&geoType=ZI";
        return $this->curlPOIAPI($url);
    }

    private function getAreaBoundary($areaid){
        $url = $this->obapiurl ."/areaapi/v2.0.0/boundary/detail?AreaId=".$areaid;
        return $this->curlPOIAPI($url);
    }
    private function curlPOIAPI($url, $apiKey = null){

        $curl = curl_init(); //cURL initialization

        //Set cURL array with require params
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 100,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "apikey: " . ($apiKey!=''?$apiKey:$this->obapikey)
            )
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        //echo "<pre>"; print_r($err); die;
        curl_close($curl);

        if ($err) {
            return '{"status": { "code": 999, "msg": "cURL Error #:" . $err."}}';
        }else{
            return json_decode($response, true);
        }
    }
}
