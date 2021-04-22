<?php

namespace App\Http\Controllers\one\Freelancer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\One\ApiLibrary;

class FreelancerController extends Controller
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

		try{
			$this->apiLib->setParams($put['data']);
			$result = $this->apiLib->generateDataAPI('GET','/api/dashboard/referral?SortByStatus='.$request->SortByStatus);
			if (!$result) {
				throw new \Exception("Failed get dashboard freelancer");
			}
			$freelancer = $result->data;
			$action = $result->action->original;

			$result_passed = $this->apiLib->generateDataAPI('GET','/api/dashboard/referral?SortByStatus=Passed');
            $result_complete = $this->apiLib->generateDataAPI('GET','/api/dashboard/referral?SortByStatus=Complete');
            $result_pending = $this->apiLib->generateDataAPI('GET','/api/dashboard/referral?SortByStatus=Pending');
            $result_inreview = $this->apiLib->generateDataAPI('GET','/api/dashboard/referral?SortByStatus=InReview');
			if (!$result_passed) {
				throw new \Exception("Failed get dashboard freelancer");
			}
            if (!$result_complete) {
				throw new \Exception("Failed get dashboard freelancer");
			}
            if (!$result_pending) {
				throw new \Exception("Failed get dashboard freelancer");
			}
            if (!$result_inreview) {
				throw new \Exception("Failed get dashboard freelancer");
			}
			$result = [
                'passed' => $result_passed->data,
                'complete' => $result_complete->data,
                'pending' => $result_pending->data,
                'inreview' => $result_inreview->data
            ];

			return view('one.freelancer.dashboardFreelancer', compact('freelancer', 'action', 'result'));

		} catch(\Exception $e) {

			$err_messages = $e->getMessage(); 
			return view('one.errors.errors', compact('err_messages'));
		}
	}

	public function adminFormcreate(Request $request)
	{
		$token = $request->session()->get('token');
		$put['data'] = ['token' => $token];
		
		$this->apiLib->setParams($put['data']);
		$result = $this->apiLib->generate('GET','/api/dashboard/referral');
		
		if($result->status == true)
		{
			$data = $result->data;
			return view('one.freelancer.FreelancerCreateAdmin',compact('data'));
		}
	}

	public function adminStore(Request $request){
		$token = $request->session()->get('token','');
		$this->setToken($token);
		$general_data = $request->only(['source','referral_name','referral_email','referral_contact_no','referral_status'
		,'job_position']);
		$multipart_data = array();
		
		if($request->file('file')){
			$multipart_data['file']   = $request->file;
		}
		
		$general_data['referral_status'] = 'Pending';
		$general_data['source'] ='web';
		$general_data['referral_employee_id'] =$request->session()->get('user_id');;
		
		$result = $this->MULTIPART(env("API_URL").'/api/dashboard/referral',$general_data,$multipart_data);

		if($result['status'] == true)
		{
			return redirect('/dashboard/freelancer')->with('success', $result['message']);
		}else{
			return redirect()->back()->with('error', $result['message']);
		} 
	}

	public function formcreate(Request $request)
	{
		$token = $request->session()->get('token');
		$put['data'] = ['token' => $token];
		
		$this->apiLib->setParams($put['data']);
		$result = $this->apiLib->generate('GET','/api/dashboard/referral');
		
		if($result->status == true)
		{
			$data = $result->data;
			return view('one.freelancer.FreelancerCreate',compact('data'));
		}
	}

	public function store(Request $request){
		$token = $request->session()->get('token','');
		$this->setToken($token);
		$general_data = $request->only(['source','referral_name','referral_email','referral_contact_no','referral_status'
		,'job_position']);
		$multipart_data = array();
		
		if($request->file('file')){
			$multipart_data['file']   = $request->file;
		}
		
		$general_data['referral_status'] = 'Pending';
		$general_data['source'] ='web';
		$general_data['referral_employee_id'] =$request->session()->get('user_id');;
		
		$result = $this->MULTIPART(env("API_URL").'/api/dashboard/referral',$general_data,$multipart_data);

		if($result['status'] == true)
		{
			return redirect('/dashboard/freelancer')->with('success', $result['message']);
		}else{
			return redirect()->back()->with('error', $result['message']);
		} 
	}

	public function adminFormUpdate(Request $request, $id){
		$token = $request->session()->get('token');
		$put['data'] = ['token' => $token];
		
		$this->apiLib->setParams($put['data']);
		$result = $this->apiLib->generate('GET','/api/dashboard/referral/update/'.$id);
		if($result->status == true)
		{
			$data = $result->data;
			return view('one.freelancer.FreelancerUpdateAdmin',compact('data'));
		}
	}

	public function adminStoreUpdate(Request $request, $id){
		$token = $request->session()->get('token','');
		$this->setToken($token);
		$general_data = $request->only(['source','referral_name','referral_email','referral_contact_no','fee','job_position']);
		$multipart_data = array();
		
		if($request->file('file')){
			$multipart_data['file'] = $request->file;
		}
		
		$general_data['source'] ='web';
		$general_data['referral_employee_id'] =$request->session()->get('user_id');;
		
		$result = $this->MULTIPART(env("API_URL").'/api/dashboard/referral/update/'.$id, $general_data, $multipart_data);

		if($result['status'] == true)
		{
			return redirect('/dashboard/freelancer')->with('success', $result['message']);
		}else{
			return redirect()->back()->with('error', $result['message']);
		} 
	}

	public function formUpdate(Request $request, $id){
		$token = $request->session()->get('token');
		$put['data'] = ['token' => $token];
		
		$this->apiLib->setParams($put['data']);
		$result = $this->apiLib->generate('GET','/api/dashboard/referral/update/'.$id);
		if($result->status == true)
		{
			$data = $result->data;
			return view('one.freelancer.FreelancerUpdate',compact('data'));
		}
	}

	public function storeUpdate(Request $request, $id){
		$token = $request->session()->get('token','');
		$this->setToken($token);
		$general_data = $request->only(['source','referral_name','referral_email','referral_contact_no','referral_status','job_position']);
		$multipart_data = array();
		
		if($request->file('file')){
			$multipart_data['file']   = $request->file;
		}
		
		$general_data['referral_status'] = 'Pending';
		$general_data['source'] ='web';
		$general_data['referral_employee_id'] =$request->session()->get('user_id');;
		
		$result = $this->MULTIPART(env("API_URL").'/api/dashboard/referral/update/'.$id, $general_data, $multipart_data);

		if($result['status'] == true)
		{
			return redirect('/dashboard/freelancer')->with('success', $result['message']);
		}else{
			return redirect()->back()->with('error', $result['message']);
		} 
	}

	public function formStatus(Request $request, $id){
		$token = $request->session()->get('token');
		$put['data'] = ['token' => $token];
		
		$this->apiLib->setParams($put['data']);
		$result = $this->apiLib->generate('GET','/api/dashboard/referral/update/'.$id.'/status');
		if($result->status == true)
		{
			$data = $result->data;
			return view('one.freelancer.FreelancerStatusUpdate',compact('data'));
		}
	}
	public function storeStatus(Request $request, $id){
		$token = $request->session()->get('token','');
		$this->setToken($token);
		$put['data'] = ['referral_status' => $request->referral_status];
		
		$this->apiLib->setParams($put['data']);
		$result = $this->apiLib->generate('POST','/api/dashboard/referral/update/'.$id.'/status');
		if($result->status == true)
		{
			return redirect('/dashboard/freelancer')->with('success', $result->message);
		}else{
			return redirect()->back()->with('error', $result['message']);
		} 
	}

	//belom terpakai && code belum di ubah
	public function dashboardFreelanceShow(Request $request, $id)
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
}
