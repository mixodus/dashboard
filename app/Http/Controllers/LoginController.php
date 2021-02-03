<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ErrorReportMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Library\ApiLibrary;

class LoginController extends Controller {
	protected $apiLib;
    protected $params;

    public function setParams($params){
        $this->params = $params;
    }

    public function getParams(){
        return  $this->params;
    }

    public function __construct()
    {
        $this->apiLib = new ApiLibrary;
    }
    public function index(Request $request) {
        return view('dashboard.auth-temp.login');
    }
}