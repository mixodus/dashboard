<?php
namespace App\Library;

use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client as GuzzleClient;

class ApiLibrary
{

    protected $endpoint;
    protected $params = [];
    protected $apiBaseUrl;
    protected $apiAuth;

    protected $error;
    protected $messages = [];
    protected $response = [];

    public function setParams($params){
        $this->params = $params;
    }

    public function getParams(){
        return $this->params;
    }

    public function generate($action = 'GET', $setEndPoint, $timeOut = 30){

        $this->apiBaseUrl = env("API_URL", "");
        $this->apiAuth = env("API_AUTH", "");
        $action = strtoupper($action);

        $endpoint = $this->apiBaseUrl.$setEndPoint;
        dd($endpoint);
        $body = "";
        if($action=="POST"){
            $query['data'] = !empty($this->params)? $this->params : [];
            $body = json_encode($query['data']);
        }else if($action=="GET"){
            if(!empty($this->params)){
                $paramArr = [];
                foreach($this->params as $keyParam => $param){
                    $paramArr[] = $keyParam."=".$param; 
                }

                if(count($paramArr)>0){
                    $endpoint .= "?".implode("&",$paramArr);
                }

            }
        }

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-Api-Key' => env('API_KEY'),       
        ];
        
        $client = new GuzzleClient([
            'headers' => $headers
        ]);

        $r = $client->request($action, $endpoint, [
            'body' => $body
        ]);
        // $response = $r->getBody()->getContents();
        // return $response;
        dd($r);
        // $endpoint = $this->apiBaseUrl.$setEndPoint;

        // $body = "";
        // if($action=="POST"){
        //     $query['data'] = !empty($this->params)? $this->params : [];
        //     $body = json_encode($query);
        // }else if($action=="GET"){
        //     if(!empty($this->params)){
        //         $paramArr = [];
        //         foreach($this->params as $keyParam => $param){
        //             $paramArr[] = $keyParam."=".$param; 
        //         }

        //         if(count($paramArr)>0){
        //             $endpoint .= "?".implode("&",$paramArr);
        //         }

        //     }
        // }

        // $curl = curl_init();
        // curl_setopt_array(
        //     $curl,
        //     array(
        //         CURLOPT_URL => $endpoint,
        //         CURLOPT_RETURNTRANSFER => true,
        //         CURLOPT_ENCODING => "",
        //         CURLOPT_MAXREDIRS => 10,
        //         CURLOPT_TIMEOUT => 30,
        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //         CURLOPT_CUSTOMREQUEST => $action,
        //         CURLOPT_POSTFIELDS => $body,
        //         CURLOPT_HTTPHEADER => array(
        //             "Accept: application/json",
        //             "Authorization: ".$this->apiAuth,
        //             "Content-Type: application/json",
        //             "cache-control: no-cache"
        //         ),
        
        //     )
        // );

        // $curlResponse = curl_exec($curl);
        // $curlError = curl_error($curl);
        // curl_close($curl);

        // if ($curlError) {
        //     $this->response['code'] = 401;
        //     $this->response['status'] = "Error";
        //     $this->response['messages'][] = $curlError;
        //     $this->response['data'] = [];

        // } else {
        //     $curlResponseArr = json_decode($curlResponse,true);
        //     $curlResponseArr = !empty($curlResponseArr[0]['code'])? $curlResponseArr[0] : $curlResponseArr;
        //     if (env("ENVIROMENT", "") !== "PRODUCTION"){
        //         if(empty($curlResponseArr['code'])){
        //             echo "<pre>";
        //             print_r($curlResponseArr);exit;
        //         }
        //     }
        //     $this->response['code'] = $curlResponseArr['code'];
        //     $this->response['status'] = $curlResponseArr['status'];
        //     $this->response['messages'] = $curlResponseArr['messages'];
        //     $this->response['data'] = $curlResponseArr['data'];
        //     $this->response['total'] = !empty($curlResponseArr['total'])? $curlResponseArr['total'] : 0;

        // }

        // return $this->response;
    }


}
?>