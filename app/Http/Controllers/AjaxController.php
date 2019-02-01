<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    private $obapiurl = 'http://search.onboard-apis.com', $obapikey = '60dca8df1d5318fe0c262baf013f185e';


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
    public function ExtendedDetail($line1, $line2)
    {
        $result = $this->getPropertyExtendDetail(urlencode($line1), urlencode($line2));
        $Propertyid = $result["property"][0]["identifier"]["obPropId"];

        $propertyAssResult = $this->getAssessmentHistory($Propertyid);
        $AVMResult = $this->getdetailmortgageowner(urlencode($line1), urlencode($line2));
        return view('test')->with('result',$result)->with('AssessmentResult',$propertyAssResult)->with("AVMResult",$AVMResult);
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
        echo json_encode(($result));
    }
    public function getHouseInventry(Request $request){
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $AreaHierarchy = $this->getAreaHierarchy($lat,$lng);
        $geoARRAY = array();
        $geoValName = array();
        foreach ($AreaHierarchy['response']['result']['package']['item'] as $key => $area) {
            $geoARRAY[]  = $area['geo_key'];
            $geoValName[$area['geo_key']] = $area['name'];
        }
        $communityData = $this->getCommunityByAreaId1($geoARRAY[0]);
        return response($communityData);
    }
    public function getCommunityByAreaId1($areaid)
    {
        $url = $this->obapiurl . "/communityapi/v2.0.0/area/full?AreaId=".$areaid;

        $result_community1 = $this->curlPOIAPI($url);

        $communityData = array();

        if(count(@$result_community1['response']['result']['package']['item'])>0){
            foreach($result_community1['response']['result']['package']['item'][0] as $resultCommKey=>$resultCommVal){
                $communityData[strtoupper($resultCommKey)] = $resultCommVal;
            }
        }

        //$communityData1[0] = $communityData;

        //$communityDataFinal = json_decode (json_encode ($communityData1), FALSE);

        return $communityData;
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
    private function getPropertyExtendDetail($line1,$line2){
        $url = $this->obapiurl . '/propertyapi/v1.0.0/property/expandedprofile?address1='.$line1.'&address2='.$line2;
        return $this->curlPOIAPI($url);
    }
    private function getAssessmentHistory($id){
        $url = $this->obapiurl . '/propertyapi/v1.0.0/assessmenthistory/detail?id='.$id;
        return $this->curlPOIAPI($url);
    }
    private function getdetailmortgageowner($line1,$line2){
        $url = $this->obapiurl . '/propertyapi/v1.0.0/property/detailmortgageowner?address1='.$line1.'&address2='.$line2;
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
            CURLOPT_TIMEOUT => 1000,
            CURLOPT_TCP_KEEPALIVE => 50,
            CURLOPT_TCP_KEEPIDLE => 100,
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
            return '{"status": { "code": 999, "msg": "cURL Error #:"'. $err.'"}}';
        }else{
            return json_decode($response, true);
        }
    }
}
