<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client as GuzzleClient;

class GetMenu
{
    protected $apiBaseUrl;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->apiBaseUrl = env("API_URL", "");
        $token = $request->session()->get('token');
        $endpoint = $this->apiBaseUrl."/api/menu";

        try {
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-Api-Key' => env('API_KEY'),  
                'X-Token'   => $token,     
            ];
            
            $client = new GuzzleClient([
                'headers' => $headers
            ]);
    
            $hits_api = $client->request("GET", $endpoint);
            $response = json_decode($hits_api->getBody());
            
            foreach($response as $data){
                $result['hits api'] = $data;
            }
           
            view()->share('appMenus', $result );
            return $next($request);
        }catch (\Throwable $e){
            $response =$e->getResponse();
            return redirect('/');
        }
    }
}