<?php

namespace App\Http\Controllers\one\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\One\ApiLibrary;
use Alert;

class EmployeeController extends Controller
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
        $result = $this->apiLib->generate('GET','/api/user-management/employee');
        
        if(!empty($result->status))
        {
            $data = $result->data;
            $action = $result->action->original;

            return view('one.employee.employeeList',compact('data', 'action'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // try {
            $token = $request->session()->get('token');
            $put['data'] = ['token' => $token, 'byEmployee' => $id];

            $this->apiLib->setParams($put['data']);
            $result = $this->apiLib->generate('GET','/api/user-management/employee-show');
            if (!$result) {
                throw new \Exception("Failed get Admin");
            }
            
            $data = $result;
            return view('one.employee.employeeView', compact('data'));
        // } catch (\Exception $e) {
        //     // return $this->services->response(404, $e->getMessage());
        // }
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
            $put['data'] = ['token' => $token, 'byEmployee' => $id];

            $this->apiLib->setParams($put['data']);
            $result = $this->apiLib->generate('GET','/api/user-management/employee-show');

            if (!$result) {
                throw new \Exception("Failed get Admin");
            }
            
            $data = $result;
            $date = null;
            if(!is_null($data->date_of_birth)){
                $date = date('Y-m-d', strtotime($data->date_of_birth));
            }
            
            return view('one.employee.employeeUpdate', compact('data', 'date'));
        } catch (\Exception $e) {
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
            'fullname' => "required|string",
			'contact_no' => "required|string",
			'country' => "required|string",
			'province' => "required|string",
			'date_of_birth' => "required|string",
			'marital_status' => "required|string",
			'gender' => "required|string|in:male,female,Male,Female",
			'job_title' => "nullable|string",
			'zip_code' => "nullable|string",
			'summary' => "nullable|string",
			'address' => "nullable|string",
			'profile_picture' => "nullable|string",
            'npwp' => "nullable|string",
            'is_active' => "nullable|integer"
        ]);     

        $data = [
            'fullname' => $request->fullname, 
            'contact_no' => $request->contact_no, 
            'country' => $request->country, 
            'province' => $request->province,
            'date_of_birth' => $request->date_of_birth,
            'marital_status' => $request->marital_status,
            'gender' => $request->gender,
            'job_title' => $request->job_title,
            'zip_code' => $request->zip_code,
            'summary' => $request->summary,
            'address' => $request->address,
            'profile_picture' => $request->profile_picture,
            'npwp' => $request->npwp,
            'is_active' => $request->is_active,
            'token' => $token
            ];
            
            $this->apiLib->setParams($data);
            $result = $this->apiLib->generate('PUT','/api/user-management/employee-update/'.$id);

        if(!empty($result->status)){
            return redirect('/dashboard/user-management/employee')->with('success',$result->message);
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
        $result = $this->apiLib->generate('delete','/api/user-management/employee-delete?byEmployee='.$id);
        
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
