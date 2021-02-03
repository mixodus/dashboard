<?php

namespace App\Http\Controllers\one\Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\One\ApiLibrary;

class LogController extends Controller
{
    public function __construct()
    {
        $this->apiLib = new ApiLibrary;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboardLog(Request $request)
    {
        $token = $request->session()->get('token');
        $put['data'] = ['token' => $token];

        try{
            $this->apiLib->setParams($put['data']);
            $result = $this->apiLib->generate('GET','/api/log/dashboard-log');

            if (!$result) {
                throw new \Exception("Failed get dashboard log");
            }

            $log = $result->data;
            return view('one.log.dashboardLoglist', compact('log'));

        } catch(\Exception $e) {

            $err_messages = $e->getMessage(); 
            return view('one.errors.errors', compact('err_messages'));
        }
    }

    public function mobileLog(Request $request)
    {
        $token = $request->session()->get('token');
        $put['data'] = ['token' => $token];

        try{
            $this->apiLib->setParams($put['data']);
            $result = $this->apiLib->generate('GET','/api/log/mobile-log');
           
            if (!$result) {
                throw new \Exception("Failed get mobile log");
            }

            $log = $result->data;
            return view('one.log.mobileLoglist', compact('log'));

        } catch(\Exception $e) {

            $err_messages = $e->getMessage(); 
            return view('one.errors.errors', compact('err_messages'));
        }
    }
    
    public function dashboardLogShow(Request $request, $id)
    {
        $token = $request->session()->get('token');
        $put['data'] = ['token' => $token];

        try{
            $this->apiLib->setParams($put['data']);
            $result = $this->apiLib->generate('GET','/api/log/dashboard-log/show?byDashboardLog='.$id);

            if (!$result) {
                throw new \Exception("Failed get dashboard log detail");
            }

            $log = $result->data;
            return view('one.log.dashboardLogView', compact('log'));

        } catch(\Exception $e) {

            $err_messages = $e->getMessage(); 
            return view('one.errors.errors', compact('err_messages'));
        }
    }

    public function mobileLogShow(Request $request, $id)
    {
        $token = $request->session()->get('token');
        $put['data'] = ['token' => $token];

        try{
            $this->apiLib->setParams($put['data']);
            $result = $this->apiLib->generate('GET','/api/log/mobile-log/show?byMobileLog='.$id);

            if (!$result) {
                throw new \Exception("Failed get mobile log detail");
            }

            $log = $result->data;
            return view('one.log.mobileLogView', compact('log'));

        } catch(\Exception $e) {

            $err_messages = $e->getMessage(); 
            return view('one.errors.errors', compact('err_messages'));
        }
    }
}
