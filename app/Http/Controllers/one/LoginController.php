<?php

namespace App\Http\Controllers\one;

use App\Http\Controllers\Controller;
use App\Mail\ErrorReportMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Library\One\ApiLibrary;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;


class LoginController extends Controller {
	protected $apiLib;
    protected $params;

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
	
        if(!empty($result->status)){

            session(['token'=> $result->data->token,'user_id'=> $result->data->user->user_id]);

            return redirect('/dashboard');
        }else{

            $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);
            return redirect('/')->withErrors($errors);
        }
    }
    
    public function logout(Request $request){

        $request->session()->forget('token');
        return redirect('/');
    }
}
