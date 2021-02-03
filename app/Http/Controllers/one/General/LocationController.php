<?php

namespace App\Http\Controllers\one\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\One\ApiLibrary;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->apiLib = new ApiLibrary;
    }

    public function get_city(Request $request, $id)
    {
        $token = $request->session()->get('token');
        $put['data'] = ['token' => $token];
        try {
            $this->apiLib->setParams($put['data']);

            $city = $this->apiLib->generate('GET','/api/location/city/'.$id);
            if (!$city) {
                throw new \Exception("Failed get role");
            }

            $data_city = $city->data;

            return response()->json(['data' => $data_city]);
        } catch (\Exception $e) {  
            $err_messages = $e->getMessage(); 
            return view('one.errors.errors', compact('err_messages'));
        }
    }
}
