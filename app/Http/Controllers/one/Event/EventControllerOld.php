<?php

namespace App\Http\Controllers\one\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\One\ApiLibrary;

class EventController_Old extends Controller
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
        $result = $this->apiLib->generate('GET', '/api/event-list');

        if (!empty($result->status)) {
            $data = $result->data;
            $action = $result->action->original;

            return view('one.event.eventList', compact('data', 'action'));
        } else {
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

            $result = $this->apiLib->generate('GET', '/api/event-type');
            if (!$result) {
                throw new \Exception("Failed get event type");
            }

            $company = $this->apiLib->generate('GET', '/api/company');
            if (!$company) {
                throw new \Exception("Failed get company");
            }

            $data_type = $result->data;
            $company = $company->data;

            return view('one.event.eventCreate', compact('data_type', 'company'));
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
        $validated = $request->validate([
            'company_id' => "required|integer",
            'event_type_id' => "required|integer",
            'event_title' => "required",
            'event_date' => "required||date_format:Y-m-d",
            'event_time' => "date_format:H:i" ?? "00:00",
            'event_note' => "required",
            'event_banner' => "required|image|mimes:jpg,png,jpeg|max:5000",
            'event_longitude' => ['regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', 'nullable'],
            'event_latitude' => ['regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', 'nullable']
        ]);

        $multipart_data = array();
        $multipart_data['event_banner']    = $request->event_banner;

        //validate data that not exist
        $request['event_time'] = $request['event_time'] ?? "00:00";

        foreach ($multipart_data as $key => $file) {
            $data[] = [
                'name'      => $key,
                'contents'  => fopen($file->getPathname(), 'r'),
                'filename'  => $file->getClientOriginalName()
            ];
        }
        $rewards = array();
        if(count($request->reward_name)>0){
            for ($i=0; $i < count($request->reward_name); $i++) { 
                $rewards[] = [
                    'reward_name' => $request->reward_name,
                    'reward_value' => $request->reward_value,
                    'reward_icon' => 'icon',
                ];
            }
        }
        $rewards = array();
        if(count($request->schedule_name)>0){
            for ($i=0; $i < count($request->schedule_name); $i++) { 
                $data['name']['name'][] = $request->schedule_name;
                $data['name']['desc'][] = $request->schedule_desc;
                $data['name']['additional_information'][] = $request->schedule_additional;
                $data['name']['schedule_start'][] = $request->schedule_start;
                $data['name']['schedule_end'][] = $request->schedule_end;
            }
        }

        $data[] = [
            'name' => 'company_id',
            'contents' => $request->company_id
        ];
        $data[] = [
            'name' => 'event_type_id',
            'contents' => $request->event_type_id
        ];
        $data[] = [
            'name' => 'event_title',
            'contents' => $request->event_title
        ];
        $data[] = [
            'name' => 'event_date',
            'contents' => $request->event_date
        ];
        $data[] = [
            'name' => 'event_time',
            'contents' => $request->event_time
        ];
        $data[] = [
            'name' => 'event_note',
            'contents' => $request->event_note
        ];
        $data[] = [
            'name' => 'event_longitude',
            'contents' => $request->event_longitude
        ];
        $data[] = [
            'name' => 'event_latitude',
            'contents' => $request->event_latitude
        ];
        $data[] = [
            'name' => 'event_charge',
            'contents' => $request->event_charge
        ];
        $data[] = [
            'name' => 'event_place',
            'contents' => $request->event_place
        ];
        $data[] = [
            'name' => 'event_speaker',
            'contents' => $request->event_speaker
        ];
        
        $data[] = [
            'name' => 'event_requirement',
            'contents' => $request->event_requirement
        ];
        $data[] = [
            'name' => 'event_additional_information',
            'contents' => $request->event_additional_information
        ];
        $data[] = [
            'name' => 'event_prize',
            'contents' => json_encode($rewards)
        ];
        $this->apiLib->setToken($token);
        $this->apiLib->setParams($data);
        $result = $this->apiLib->generateUpload('POST', '/api/event-create');

        if (!empty($result->status)) {
            return redirect('/dashboard/event')->with('success', $result->message);
        } else {
            return redirect('/dashboard/event/create')->with('error', $result->message);
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
        $put['data'] = ['token' => $token, 'byEventid' => $id];
        try {
            $this->apiLib->setParams($put['data']);

            $result = $this->apiLib->generate('GET', '/api/event-show');
            if (!$result) {
                throw new \Exception("Failed get event");
            }

            $data_event = $result->data[0];

            return view('one.event.eventView', compact('data_event'));
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
    public function edit(Request $request, $id)
    {
        $token = $request->session()->get('token');
        $put['data'] = ['token' => $token, 'byEventid' => $id];
        try {
            $this->apiLib->setParams($put['data']);

            $result = $this->apiLib->generate('GET', '/api/event-show');
            if (!$result) {
                throw new \Exception("Failed get event");
            }

            $event_type = $this->apiLib->generate('GET', '/api/event-type');
            if (!$event_type) {
                throw new \Exception("Failed get event type");
            }

            $company = $this->apiLib->generate('GET', '/api/company');
            if (!$company) {
                throw new \Exception("Failed get company");
            }

            $data_type = $event_type->data;
            $company = $company->data;
            $data_event = $result->data[0];

            return view('one.event.eventUpdate', compact('data_event', 'data_type', 'company'));
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
            'event_type_id' => "required|integer",
            'event_title' => "required",
            'event_date' => "required||date_format:Y-m-d",
            'event_time' => "date_format:H:i",
            'event_note' => "required",
            'event_banner' => "image|mimes:jpg,png,jpeg|max:5000",
            'event_longitude' => ['regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', 'nullable'],
            'event_latitude' => ['regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', 'nullable']
        ]);

        $multipart_data = array();
        $multipart_data['event_banner']    = $request->event_banner;
        $request['event_time'] = $request['event_time'] ?? "00:00";
        
        
        if (!empty($request->event_banner)) {
            foreach ($multipart_data as $key => $file) {
                $data[] = [
                    'name'      => $key,
                    'contents'  => fopen($file->getPathname(), 'r'),
                    'filename'  => $file->getClientOriginalName()
                ];
            }
        }
        
        $rewards = array();
        if(count($request->reward_name)>0){
            for ($i=0; $i < count($request->reward_name); $i++) { 
                $rewards[] = [
                    'reward_name' => $request->reward_name,
                    'reward_value' => $request->reward_value,
                    'reward_icon' => 'icon',
                ];
            }
        }
        if(count($request->schedule_name)>0){
            for ($i=0; $i < count($request->schedule_name); $i++) { 
                $data['name']['name'][] = $request->schedule_name;
                $data['name']['desc'][] = $request->schedule_desc;
                $data['name']['additional_information'][] = $request->schedule_additional;
                $data['name']['schedule_start'][] = $request->schedule_start;
                $data['name']['schedule_end'][] = $request->schedule_end;
            }
        }

        $data[] = [
            'name' => 'company_id',
            'contents' => $request->company_id
        ];
        $data[] = [
            'name' => 'event_type_id',
            'contents' => $request->event_type_id
        ];
        $data[] = [
            'name' => 'event_title',
            'contents' => $request->event_title
        ];
        $data[] = [
            'name' => 'event_date',
            'contents' => $request->event_date
        ];
        $data[] = [
            'name' => 'event_time',
            'contents' => $request->event_time
        ];
        $data[] = [
            'name' => 'event_note',
            'contents' => $request->event_note
        ];
        $data[] = [
            'name' => 'event_longitude',
            'contents' => $request->event_longitude
        ];
        $data[] = [
            'name' => 'event_latitude',
            'contents' => $request->event_latitude
        ];
        $data[] = [
            'name' => 'event_charge',
            'contents' => $request->event_charge
        ];
        $data[] = [
            'name' => 'event_place',
            'contents' => $request->event_place
        ];
        $data[] = [
            'name' => 'event_speaker',
            'contents' => $request->event_speaker
        ];
        $data[] = [
            'name' => 'event_requirement',
            'contents' => $request->event_requirement
        ];
        $data[] = [
            'name' => 'event_additional_information',
            'contents' => $request->event_additional_information
        ];
        $data[] = [
            'name' => 'event_prize',
            'contents' => json_encode($rewards)
        ];

        $this->apiLib->setToken($token);
        $this->apiLib->setParams($data);
        $result = $this->apiLib->generateUpload('POST', '/api/event-update?byEventid='. $id);

        if (!empty($result->status)) {
            return redirect('/dashboard/event')->with('success', $result->message);
        } else {
            return redirect()->back()->with('error', $result->message);
        }
    }

    public function updateHackathon(Request $request, $id)
    {
        $token = $request->session()->get('token','');
        $this->setToken($token);
        $general_data = $request->except(['reward_icon','_token','event_prize','reward_name','reward_value'
        ,'schedule_name','schedule_desc','schedule_additional','schedule_start','schedule_end','schedule_link','icon_schedule_default',
        'icon_schedule_failed','icon_schedule_pending','event_banner']);
        $multipart_data = array();
        if($request->file('event_banner')){
            $multipart_data['event_banner']   = $request->event_banner;
        }
        if($request->reward_icon){
            $img = $request->reward_icon;
            foreach($img as $key)
            {
                if(file_exists($key)) {
                    if ($key != null) {
                        $multipart_data['reward_icon'][] = $key;
                    }
                }else{
                    $general_data['reward_icon'][] = $key;
                }
            }
        }
        if($request->icon_schedule_default){
            $img = $request->icon_schedule_default;
            foreach($img as $key)
            {
                if(file_exists($key)) {
                    if ($key != null) {
                        $multipart_data['icon_schedule_default'][] = $key;
                        
                    }
                }else{
                    $general_data['icon_schedule_default'][] = $key;
                }
            }
        }
        if($request->icon_schedule_failed){
            $img = $request->icon_schedule_failed;
            foreach($img as $key)
            {
                if(file_exists($key)) {
                    if ($key != null) {
                        $multipart_data['icon_schedule_failed'][] = $key;
                    }
                }else{
                    $general_data['icon_schedule_failed'][] = $key;
                }
            }
        }
        if($request->icon_schedule_pending){
            $img = $request->icon_schedule_pending;
            foreach($img as $key)
            {
                if(file_exists($key)) {
                    if ($key != null) {
                        $multipart_data['icon_schedule_pending'][] = $key;
                    }
                }else{
                    $general_data['icon_schedule_pending'][] = $key;
                }
            }
        }
    
        $dataReward= array();
        if(count($request['reward_name'])){
            for ($i=0; $i < count($request->reward_name); $i++) { 
                $general_data['reward_name'][$i] = $request['reward_name'][$i];
                $general_data['reward_value'][$i] = $request['reward_value'][$i];
            }
        } 
        $request['schedule_id']= array_unique($request['schedule_id']);
        $general_data['is_road_map'] = true;
        for ($i=0; $i < count($request->schedule_name); $i++) { 
            $general_data['schedule_id'][] = $request['schedule_id'][$i];
            $general_data['schedule_start'][] = $request['schedule_start'][$i];
            $general_data['schedule_end'][] = $request['schedule_end'][$i];
            $general_data['name'][] = $request['schedule_name'][$i];
            $general_data['desc'][] = $request['schedule_desc'][$i];
            $general_data['link'][] = $request['schedule_link'][$i];
            $general_data['additional_information'][] = $request['schedule_additional'][$i];
        }   
    }   
        $response = $this->MULTIPART(env("API_URL").'/api/event-update?byEventid='. $id,$general_data, $multipart_data);
        dd($response);
        if ($response['status']==true) {
            return redirect('/dashboard/hackathon')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('error', $respons['message']);
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
        $result = $this->apiLib->generate('delete', '/api/event-delete?byEventid=' . $id);

        if (!empty($result->status)) {
            $success = true;
            $message = $result->message;
        } else {
            $success = false;
            $message = $result->message;
        }

        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function registerStatus(Request $request, $id)
    {
        $token = $request->session()->get('token');
        $validated = $request->validate([
            'status' => "required|in:Waiting Approval,Approved,Not Approved",
        ]);
        
        $data = [
            'status' => $request->status,
            'token' => $token
            ];

        $this->apiLib->setParams($data);
        $result = $this->apiLib->generate('PUT','/api/event/participant-status/update?byRegisid='.$id);
        
        if(!empty($result->status)){
            return redirect()->back()->with('success', $result->message);
        }else{
            return redirect()->back()->with('error', $result->message);
        }
    }

    public function hackathon(Request $request)
    {
        $token = $request->session()->get('token');
        $put['data'] = ['token' => $token];
        $this->apiLib->setParams($put['data']);
        $result = $this->apiLib->generate('GET', '/api/dashboard/hacktown');
        $company = $this->apiLib->generate('GET', '/api/company');
        if (!$company) {
            throw new \Exception("Failed get company");
        }
        $company = $company->data;
        if (!empty($result->status)) {
            $data = $result->data;
            $action = $result->action->original;
            return view('one.event.hackathon.view', compact('data', 'action', 'company'));
        } else {
            $err_messages = "Server Error";
            return view('one.errors.errors', compact('err_messages'));
        }
    }
}
