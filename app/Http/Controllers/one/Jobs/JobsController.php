<?php

namespace App\Http\Controllers\one\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\One\ApiLibrary;
use Alert;

class JobsController extends Controller
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
        $result = $this->apiLib->generate('GET','/api/jobs');
        
        if(!empty($result->status))
        {
            $data = $result->data;
            $action = $result->action->original;

            return view('one.jobs.jobsList',compact('data', 'action'));
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
    public function create(Request $request)
    {
        $token = $request->session()->get('token');
        $put['data'] = ['token' => $token];
        try {
            $this->apiLib->setParams($put['data']);

            $company = $this->apiLib->generate('GET','/api/company');
            if (!$company) {
                throw new \Exception("Failed get company");
            }

            $country = $this->apiLib->generate('GET','/api/location/country');
            if (!$country) {
                throw new \Exception("Failed get country");
            }

            $province = $this->apiLib->generate('GET','/api/location/province');
            if (!$province) {
                throw new \Exception("Failed get province");
            }

            $data_company = $company->data;
            $data_country = $country->data;
            $data_province = $province->data;

            return view('one.jobs.jobsCreate', compact('data_country','data_province', 'data_company'));
        } catch (\Exception $e) {  
            $err_messages = $e->getMessage(); 
            return view('one.errors.errors', compact('err_messages'));
        }
        
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

        $data = [
            'company_id' => $request->company_id,
            'job_title' => $request->job_title,
            'designation_id' => $request->designation_id,
            'job_type' => $request->job_type,
            'job_vacancy' => $request->job_vacancy,
            'gender' => $request->gender,
            'minimum_experience' => $request->minimum_experience,
            'date_of_closing' => $request->date_of_closing,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'status' => $request->status,
            'country' => $request->country,
            'province' => $request->province,
            'city_id' => $request->city_id,
            'districts_id' => $request->districts_id,
            'subdistrict_id' => $request->subdistrict_id,
            'currency_id' => $request->currency_id,
            'salary_desc' => $request->salary_desc,
            'salary_start' => $request->salary_start,
            'salary_end' => $request->salary_end,
            'token' => $token
            ];
        

        $this->apiLib->setParams($data);
        $result = $this->apiLib->generate('POST','/api/jobs/create');
        if($result->status == true){
             return redirect('/dashboard/jobs')->with('success', $result->message);
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
        $token = $request->session()->get('token');
        $put['data'] = ['token' => $token];
        try {
            $this->apiLib->setParams($put['data']);
            $get_job = $this->apiLib->generate('GET','/api/jobs/show/'.$id);
            if (!$get_job) {
                throw new \Exception("Failed get job");
            }

            $company = $this->apiLib->generate('GET','/api/company');
            if (!$company) {
                throw new \Exception("Failed get company");
            }

            $country = $this->apiLib->generate('GET','/api/location/country');
            if (!$country) {
                throw new \Exception("Failed get country");
            }

            $province = $this->apiLib->generate('GET','/api/location/province');
            if (!$province) {
                throw new \Exception("Failed get province");
            }

            

            $data_job = $get_job->data;
            $data_company = $company->data;
            $data_country = $country->data;
            $data_province = $province->data;

            $city = $this->apiLib->generate('GET','/api/location/city/'.$data_job->province);
            if (!$city) {
                throw new \Exception("Failed get role");
            }
            $data_city = $city->data;

            $date = null;
            if(!is_null($data_job->date_of_closing)){
                $date = date('Y-m-d', strtotime($data_job->date_of_closing));
            }

            return view('one.jobs.jobsUpdate', compact('data_job','data_country','data_province', 'data_company', 'data_city', 'date'));
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
            'company_id' => "required|integer",
            'job_title' => 'required|string',
            'designation_id' => 'required|integer',
            'job_type' => 'required|integer',
            'job_vacancy' => 'required|integer',
            'gender' => 'required|string',
            'minimum_experience' => 'nullable|string',
            'date_of_closing' => 'required|date',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'status' => 'required|integer',
            'country' => 'nullable|string',
            'province' => 'nullable|integer',
            'city_id' => 'nullable|integer',
            'districts_id' => 'nullable|integer',
            'subdistrict_id' => 'nullable|integer',
            'currency_id' => 'required|integer',
            'salary_desc' => 'nullable|string',
            'salary_start' => 'integer',
            'salary_end' => 'integer',
        ]);

        $data = [
            'company_id' => $request->company_id,
            'job_title' => $request->job_title,
            'designation_id' => $request->designation_id,
            'job_type' => $request->job_type,
            'job_vacancy' => $request->job_vacancy,
            'gender' => $request->gender,
            'minimum_experience' => $request->minimum_experience,
            'date_of_closing' => $request->date_of_closing,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'status' => $request->status,
            'country' => $request->country,
            'province' => $request->province,
            'city_id' => $request->city_id,
            'districts_id' => $request->districts_id,
            'subdistrict_id' => $request->subdistrict_id,
            'currency_id' => $request->currency_id,
            'salary_desc' => $request->salary_desc,
            'salary_start' => $request->salary_start,
            'salary_end' => $request->salary_end,
            'token' => $token
            ];

        $this->apiLib->setParams($data);
        $result = $this->apiLib->generate('PUT','/api/jobs/update/'.$id);
        
        if(!empty($result->status)){
            return redirect('/dashboard/jobs')->with('success', $result->message);
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
        $result = $this->apiLib->generate('delete','/api/jobs/delete?byJobs='.$id);
        
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

    public function details(Request $request, $id)
    {
        $token = $request->session()->get('token');
        $put['data'] = ['token' => $token];
        try {
            $this->apiLib->setParams($put['data']);
            $get_job = $this->apiLib->generate('GET','/api/jobs/show/'.$id);
            if (!$get_job) {
                throw new \Exception("Failed get job");
            }
            $company = $this->apiLib->generate('GET','/api/company/'.$get_job->data->company_id);
            if (!$company) {
                throw new \Exception("Failed get company");
            }

            $country = $this->apiLib->generate('GET','/api/location/country/'.$get_job->data->country);
            if (!$country) {
                throw new \Exception("Failed get country");
            }

            $province = $this->apiLib->generate('GET','/api/location/province/'.$get_job->data->province);
            if (!$province) {
                throw new \Exception("Failed get province");
            }

            

            $data_job = $get_job->data;
            $data_company = $company->data;
            $data_country = $country->data;
            $data_province = $province->data;

            $city = $this->apiLib->generate('GET','/api/location/city/id/'.$get_job->data->city_id);
            if (!$city) {
                throw new \Exception("Failed get role");
            }
            $data_city = $city->data;

            $date = null;
            if(!is_null($data_job->date_of_closing)){
                $date = date('Y-m-d', strtotime($data_job->date_of_closing));
            }

            $participant = $this->apiLib->generate('GET','/api/job_post/'.$id.'/users');
            $data_participant = $participant->data;

            return view('one.jobs.jobsDetails', compact('data_job','data_country','data_province', 'data_company', 'data_city', 'date','data_participant'));
        } catch (\Exception $e) {  
            $err_messages = $e->getMessage(); 
            return view('one.errors.errors', compact('err_messages'));
        }
    }
}
