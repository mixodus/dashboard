<?php

namespace App\Http\Controllers\one\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\One\ApiLibrary;
use Alert;

class AdminController extends Controller
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
        $result = $this->apiLib->generate('GET','/api/admin');
        
        if(!empty($result->status))
        {
            $data = $result->data;
            $action = $result->action->original;

            return view('one.admin.usersList',compact('data', 'action'));
        }else{
            $err_messages = "Server Error"; 
            return view('one.errors.errors', compact('err_messages'));
        }
    }

    public function formcreate(Request $request)
    {
        $token = $request->session()->get('token');
        $put['data'] = ['token' => $token];
        
        $this->apiLib->setParams($put['data']);
        $result = $this->apiLib->generate('GET','/api/settings/roles');
        
        if($result->status == true)
        {
            $data = $result->data;
            return view('one.admin.usersCreate',compact('data'));
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
            'first_name' => 'required|string|min:3',
            'company_name' => 'required',
            'role_id' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'password' => ['required', 'min:6', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/','required_with:confrim_password','same:confrim_password'],
            'confrim_password' => 'required'
        ]);

        $put['data'] = ['first_name' => $request->first_name, 
                 'company_name' => $request->company_name, 
                 'role_id' => $request->role_id,
                 'email' => $request->email,
                 'password' => $request->password,
                 'confrim_password' => $request->confrim_password
                ];
        
        $this->apiLib->setParams($put['data']);
        $result = $this->apiLib->generate('POST','/admin/register');
        
        if($result->status == true)
        {
            return redirect('/dashboard/user-management/admin')->with('success', $result->message);
        }else{
            return redirect()->back()->with('error', $result->message);
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
        try {
            $token = $request->session()->get('token');
            $put['data'] = ['token' => $token, 'user_id' => $id];

            $this->apiLib->setParams($put['data']);
            $result = $this->apiLib->generate('GET','/api/admin/show');
            if (!$result) {
                throw new \Exception("Failed get Admin");
            }
            
            $data = $result->data;
            return view('one.Admin.usersView', compact('data'));
        } catch (\Exception $e) {
            return $this->services->response(404, $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        try {
            $token = $request->session()->get('token');
            $put['data'] = ['token' => $token, 'user_id' => $id];

            $this->apiLib->setParams($put['data']);
            $result = $this->apiLib->generate('GET','/api/admin/show');
            if (!$result) {
                throw new \Exception("Failed get Admin");
            }

            $this->apiLib->setParams($put['data']);
            $result_role = $this->apiLib->generate('GET','/api/settings/roles');
            
            $data = $result->data;
            $data_role = $result_role->data;
            return view('one.Admin.usersUpdate', compact('data', 'data_role'));
        } catch (\Exception $e) {
            // return $this->services->response(404, $e->getMessage());
            $err_messages = $e->getMessage(); 
            return view('one.errors.errors', compact('err_messages'));
        }
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
        $token = $request->session()->get('token');
        $validated = $request->validate([
            'first_name' => 'required|string|max:10|min:3',
            'company_name' => 'required',
            'role_id' => 'required',
            'is_active' => 'required|integer|max:1'
        ]);     

            $put['data'] = [
                            'first_name' => $request->first_name, 
                            'company_name' => $request->company_name, 
                            'role_id' => $request->role_id, 
                            'is_active' => $request->is_active, 
                            'token' => $token
                        ];
            $this->apiLib->setParams($put['data']);
            $result = $this->apiLib->generate('PUT','/api/admin/admin-update/'.$id);

        if(!empty($result->status)){
            return redirect('/dashboard/user-management/admin')->with('success', $result->message);
        }else{
            return redirect()->back()->with('error', $result->message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $token = $request->session()->get('token');
        $data = ['token' => $token];
        $this->apiLib->setParams($data);
        $result = $this->apiLib->generate('delete','/api/admin/admin-delete/'.$id);
        
        if(!empty($result->status))
        {
            $success = true;
            $message = $result->message;
        }else{
            $success = false;
            $message = $result->message;
        }

        return response()->json(['success' => $success, 'message' => $message]);
    }
}
