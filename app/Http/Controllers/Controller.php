<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use config\constants;
use Redirect;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $_client;
    public function __construct(Request $request) {
        parent::__construct();
        $this->_client = new Client();
        $this->request = $request;
    }


    protected function POST($url,$data = [], $headers = [], $timeout = ['connection_timeout' => 600,'timeout'=> 600]){
        return json_decode($this->_client->POST($url,[
            'headers' => $headers,
            'form_params' => $data,
            $timeout
        ])->getBody(),true);
    }

    protected function GET($url,$data = [], $headers = [], $timeout = ['connection_timeout' => 600,'timeout'=> 600]){
        return json_decode($this->_client->GET($url,[
            'form_params'   => $data,
            'headers'       => $headers,
            $timeout
        ])->getBody(),true);
    }

    protected function MULTIPART($url,$general_data, $multipart_data){
        $data = [];
        foreach($general_data as $key => $item){
            if (is_array($item)) {
                foreach($item as $items){
                    $data[] = [
                        'name'      => $key.'[]',
                        'contents'  => $items
                    ];
                }
            }else{
                $data[] = [
                    'name'      => $key,
                    'contents'  => $item
                ];
            }
        }
        foreach($multipart_data as $key => $file){
            if($file){
                if (is_array($file)) {
                    foreach ($file as $row) {
                        $data[] = [
                            'name'      => $key.'[]',
                            'contents'  => fopen($row->getPathname(),'r'),
                            'filename'  => $row->getClientOriginalName()
                        ];
                    }
                }else{
                    $data[] = [
                        'name'      => $key,
                        'contents'  => fopen($file->getPathname(),'r'),
                        'filename'  => $file->getClientOriginalName()
                    ];
                }
            }
        }
        
        $client = new Client();
        // $boundary = 'my_custom_boundary';
        return json_decode($client->POST($url,[
            'headers' =>  [
                'Accept' => 'application/json',
                // 'Content-Type' => 'multipart/form-data; boundary='.$boundary,
                'X-Api-Key' => env('API_KEY'),
                'X-Token'  => $this->token
            ],
            'multipart' => $data,
            $timeout = ['connection_timeout' => 600,'timeout'=> 600]
        ])->getBody(),true);
    }
    public function setToken($token){
        $this->token   = $token;
    }

}
