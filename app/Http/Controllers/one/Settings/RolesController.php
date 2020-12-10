<?php

namespace App\Http\Controllers\one\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\One\ApiLibrary;

class RolesController extends Controller
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
        $action = ['vew', 'delete'];

        $this->apiLib->setParams($put['data']);
        $result = $this->apiLib->generate('GET','/api/settings/roles');
        
        if($result->status == true)
        {
            $data = $result->data;
            $action = $result->action->original;
            return view('one.role.roleList',compact('data', 'action'));
        }else{
            dd('b');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function formcreate(Request $request)
    {
        $token = $request->session()->get('token');
        $put['data'] = ['token' => $token];
        
        $this->apiLib->setParams($put['data']);
        $result = $this->apiLib->generate('GET','/api/settings/permissions');
        
        if($result->status == true)
        {
            $data = $result->data;
            return view('one.role.roleCreate',compact('data'));
        }else{
            dd('b');
        }
    }
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
        $validated = $request->validate([
            'role_name' => 'required|string|max:20|min:2',
            'company' => 'required',
            'action' => 'required|array'

        ]);

        $token = $request->session()->get('token');
        $valn = [];
		foreach($request->action as $a)
		{
			$tes= explode("-", $a);
			$permission= ['menu_id' => $tes[0], 'action' =>$tes[1]]; 
			array_push($valn, $permission);
        }
        $data = ['company_id' => 1, 'role_name' => $request->role_id, 'token' => $token];
        $data['permissions'] = $valn;
        
        $this->apiLib->setParams($data);
        $result = $this->apiLib->generate('POST','/api/settings/roles-create');
        
        if($result->status == true)
        {
            return redirect('/dashboard/settings/roles')->with('success',$result->message);
        }else{
            return redirect('/dashboard/settings/roles/edit/'.$id)->with('error',$result->message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // \DB::beginTransaction();
        try {
            $token = $request->session()->get('token');
            $put['data'] = ['token' => $token, 'role_id' => $id];

            $this->apiLib->setParams($put['data']);
            $result = $this->apiLib->generate('GET','/api/settings/roles-show');
            if (!$result) {
                throw new \Exception("Failed get role");
            }

            $result_permission = $this->apiLib->generate('GET','/api/settings/permissions');
            if (!$result_permission) {
                throw new \Exception("Failed get permission");
            }

            $result_rolepermission = $this->apiLib->generate('GET','/api/settings/roles-edit');
            if (!$result_rolepermission) {
                throw new \Exception("Failed get role permission");
            }
        // \DB::commit();
            $data = $result->data;
            $permission = $result_permission->data;
            $role_permission = ($result_rolepermission->data != "")? $result_rolepermission->data : [];
            
            return view('one.role.roleUpdate',compact('data', 'permission', 'role_permission'));
        } catch (\Exception $e) {
        //     \DB::rollback();
        
            return $this->services->response(404, $e->getMessage());
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
        $valn = [];
		foreach($request->action as $a)
		{
			$tes= explode("-", $a);
			$permission= ['menu_id' => $tes[0], 'action' =>$tes[1]]; 
			array_push($valn, $permission);
        }
        $data = ['company_id' => 1, 'role_name' => $request->role_id, 'token' => $token];
        $data['permissions'] = $valn;
        
        $this->apiLib->setParams($data);
        $result = $this->apiLib->generate('PUT','/api/settings/roles-update/'.$id);
        
        if($result->status == true)
        {
            return redirect('/dashboard/settings/roles')->with('success',$result->message);
        }else{
            return redirect('/dashboard/settings/roles/edit/'.$id)->with('error',$result->message);
        }
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
