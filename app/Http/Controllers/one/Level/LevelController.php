<?php

namespace App\Http\Controllers\one\Level;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\One\ApiLibrary;
use Alert;

class LevelController extends Controller
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
    public function index(Request $request)
    {
        $token = $request->session()->get('token');
        $put['data'] = ['token' => $token];
        
        $this->apiLib->setParams($put['data']);
        $result = $this->apiLib->generate('GET','/api/user-management/employee-level');
        
        if(!empty($result->status))
        {
            $data = $result->data;

            return view('one.level.levelList',compact('data'));
        }else{
            $err_messages = "Server Error"; 
            return view('one.errors.errors', compact('err_messages'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $token = $request->session()->get('token');
        $validated = $request->validate([
            'activity_point_id' => "required|integer",
        ]);
        
        $data = [
            'activity_point_id' => $request->activity_point_id,
            'employee_id' => $request->employee_id,
            'token' => $token
            ];

        $this->apiLib->setParams($data);
        $result = $this->apiLib->generate('POST','/api/user-management/employee-level/create');
        if(!empty($result->status)){
            toast('Success add activity point','success');
            return redirect('/dashboard/user-management/employee-level/view/'.$request->employee_id);
        }else{
            toast('Failed add activity point','error');
            return redirect('/dashboard/user-management/employee-level/view/'.$request->employee_id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $token = $request->session()->get('token');
        $put['data'] = ['token' => $token, 'byEmployee' => $id];
        try {
            $this->apiLib->setParams($put['data']);

            $result = $this->apiLib->generate('GET','/api/user-management/employee-level/detail');
            if (!$result) {
                throw new \Exception("Failed get company");
            }

            $data = $result->data;
            $activity = $result->action;

            return view('one.level.levelView',compact('data', 'activity'));
        } catch (\Exception $e) {
            $err_messages = $e->getMessage(); 
            return view('one.errors.errors', compact('err_messages'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
