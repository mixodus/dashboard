<?php

namespace App\Http\Controllers\one;

use App\Http\Controllers\Controller;
use App\Mail\ErrorReportMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Library\One\ApiLibrary;
use Illuminate\Support\Facades\Http;


class LoginController extends Controller {
	protected $apiLib;
    protected $params;

    // public function setParams($params){
    //     $this->params = $params;
    // }

    // public function getParams(){
    //     return  $this->params;
    // }

    public function __construct()
    {
        $this->apiLib = new ApiLibrary;
    }
    public function index(Request $request) {
        $failed_login_status = false;
        return view('one.login.login');
    }
    
    public function login(Request $request) {

        $put['data'] = [
            'username' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        $this->apiLib->setParams($put['data']);
        $result = $this->apiLib->generate('POST','/admin/login');
        // $tamp = json_encode($result->getContent());
        // dd($result->data);
        if($result->status == true){
            // dd($result->data->token);
            /*
            Get member data login
            */
            session(['token'=> $result->data->token]);
            // $data = $result;
            // $request->session()->put('member', $data);
            // $request->session()->flush();
            return redirect('/dashboard');
        }else{
            dd($result);
        //     $failed_login_status = true;
        //     return view('pages.login')
        //     ->with('failed_login_status', $failed_login_status);
        }
    }
    
    public function logout(Request $request){

        $request->session()->forget('token');
        return redirect('/');

    }
}