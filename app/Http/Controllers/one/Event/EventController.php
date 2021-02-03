<?php

namespace App\Http\Controllers\one\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\One\ApiLibrary;

class EventController extends Controller
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
            'event_time' => "required|date_format:H:i",
            'event_note' => "required",
            'event_banner' => "required|image|mimes:jpg,png,jpeg|max:5000",
            'event_longitude' => ['regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', 'nullable'],
            'event_latitude' => ['regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', 'nullable']
        ]);

        $multipart_data = array();
        $multipart_data['event_banner']    = $request->event_banner;

        foreach ($multipart_data as $key => $file) {
            $data[] = [
                'name'      => $key,
                'contents'  => fopen($file->getPathname(), 'r'),
                'filename'  => $file->getClientOriginalName()
            ];
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
            'event_time' => "required|date_format:H:i",
            'event_note' => "required",
            'event_banner' => "image|mimes:jpg,png,jpeg|max:5000",
            'event_longitude' => ['regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', 'nullable'],
            'event_latitude' => ['regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', 'nullable']
        ]);

        $multipart_data = array();
        $multipart_data['event_banner']    = $request->event_banner;
        
        if (!empty($request->event_banner)) {
            foreach ($multipart_data as $key => $file) {
                $data[] = [
                    'name'      => $key,
                    'contents'  => fopen($file->getPathname(), 'r'),
                    'filename'  => $file->getClientOriginalName()
                ];
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

        $this->apiLib->setToken($token);
        $this->apiLib->setParams($data);
        $result = $this->apiLib->generateUpload('POST', '/api/event-update?byEventid='. $id);

        if (!empty($result->status)) {
            return redirect('/dashboard/event')->with('success', $result->message);
        } else {
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
}
