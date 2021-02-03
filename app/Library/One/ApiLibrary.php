<?php
namespace App\Library\One;

use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client as GuzzleClient;

use Illuminate\Http\Request;

class ApiLibrary
{

    protected $endpoint;
    protected $params = [];
    protected $token = [];
    protected $apiBaseUrl;
    protected $apiAuth;

    protected $error;
    protected $messages = [];
    protected $response = [];

    public function setParams($params){
        $this->params   = $params;
    }

    public function setToken($token){
        $this->token   = $token;
    }

    public function getParams(){
        return $this->params;
    }

    public function generate($action = '', $setEndPoint, $timeOut = 30){
        
        $this->apiBaseUrl = env("API_URL", "");
        $action = strtoupper($action);
        
        $endpoint = $this->apiBaseUrl.$setEndPoint;
        
        $body = "";
        if($action=="POST"){
            $query['data'] = !empty($this->params)? $this->params : [];
            $body = json_encode($query['data']);
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-Api-Key' => env('API_KEY'),
                'X-Token'  => (!empty($query['data']['token']))?$query['data']['token']:''
            ];
        }else if($action=="GET"){
            $query['data'] = !empty($this->params)? $this->params : [];
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-Api-Key' => env('API_KEY'),
                'X-Token'  => $query['data']['token']     
            ];
            $check = (count($query['data']) > 0)? $this->params : [];
            $body = json_encode($check);
        }else if($action=="PUT"){
            $query['data'] = !empty($this->params)? $this->params : [];
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-Api-Key' => env('API_KEY'),
                'X-Token'  => $query['data']['token']     
            ];
            $check = (count($query['data']) > 1)? $this->params : [];
            $body = json_encode($check);
        }else{
            $query['data'] = !empty($this->params)? $this->params : [];
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-Api-Key' => env('API_KEY'),
                'X-Token'  => $query['data']['token']     
            ];
            $check = (count($query['data']) > 1)? $this->params : [];
            $body = json_encode($check);
        }
        
        try {
            $client = new GuzzleClient([
                'headers' => $headers
            ]);
    
            $hits_api = $client->request($action, $endpoint, [
                'body' => $body  
            ]);
            $response = json_decode($hits_api->getBody());
            return $response;
        }catch (\Throwable $e){
            $response = $e->getResponse();
            $responseBody = json_decode($response->getBody()->getContents());
            return $responseBody;
        }
    }

    public function generateUpload($action = '', $setEndPoint, $timeOut = 30){

        $this->apiBaseUrl = env("API_URL", "");
        $action = strtoupper($action);
        
        $endpoint = $this->apiBaseUrl.$setEndPoint;
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'multipart/form-data',
            'X-Api-Key' => env('API_KEY'),
            'X-Token'  => $this->token
        ];

        try {
            $client = new GuzzleClient([
                'headers' => $headers,
                'multipart' => $this->params
            ]);
    
            $hits_api = $client->request($action, $endpoint);

            $response = json_decode($hits_api->getBody());
            return $response;
        }catch (\Throwable $e){
            $response = $e->getResponse();
            $responseBody = json_decode($response->getBody()->getContents());
            return $responseBody;
        }
    }
}
?>