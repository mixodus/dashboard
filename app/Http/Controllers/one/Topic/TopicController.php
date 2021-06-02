<?php

namespace App\Http\Controllers\one\Topic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\One\ApiLibrary;

class TopicController extends Controller
{
	public function __construct()
	{
		$this->apiLib = new ApiLibrary;
	}

    public function index(Request $request)
	{
		$token = $request->session()->get('token');
		$put['data'] = ['token' => $token];

		try{
			$this->apiLib->setParams($put['data']);
			$result = $this->apiLib->generateDataAPI('GET','/api/votes/topic');
			if (!$result) {
				throw new \Exception("Failed get Topic");
			}
			$topics = $result->data;
			$action = $result->action->original;

			return view('one.voting.votingTopic', compact('topics', 'action'));

		} catch(Exception $e) {
			$err_messages = $e->getMessage(); 
			return view('one.errors.errors', compact('err_messages'));
		}
	}

	public function details(Request $request, $id)
	{
		$token = $request->session()->get('token');
		$put['data'] = ['token' => $token];

		try{
			$this->apiLib->setParams($put['data']);
			$result = $this->apiLib->generateDataAPI('GET','/api/votes/candidate?topic_id='.$id);
			if (!$result) {
				throw new \Exception("Failed get Topic");
			}
			$details = $result->data;
			$action = $result->action->original;

			return view('one.voting.votingTopicDetails', compact('details', 'action'));

		} catch(Exception $e) {
			$err_messages = $e->getMessage(); 
			return view('one.errors.errors', compact('err_messages'));
		}
	}

	public function topicFormCreate(){
		return view('one.voting.votingTopicCreate');
	}

	public function topicFormCreateStore(Request $request){
		$token = $request->session()->get('token','');
		$this->setToken($token);
		$general_data = $request->only(['name','title']);
		$multipart_data = array();
		
		if($request->file('banner')){
			$multipart_data['banner']   = $request->banner;
		}
		
		$result = $this->MULTIPART(env("API_URL").'/api/votes/create-topic',$general_data,$multipart_data);

		if($result['status'] == true)
		{
			return redirect('/dashboard/voting')->with('success', $result['message']);
		}else{
			return redirect()->back()->with('error', $result['message']);
		} 
	}

	public function topicFormUpdate(Request $request, $id){
		$token = $request->session()->get('token');
		$put['data'] = ['token' => $token];
		
		$this->apiLib->setParams($put['data']);
		$result = $this->apiLib->generate('GET','/api/votes/topic/'.$id);
		if($result->status == true)
		{
			$data = $result->data;
			return view('one.voting.votingTopicUpdate',compact('data'));
		}else{
			return redirect()->back()->with('error', $result['message']);
		} 
	}

	public function topicFormUpdateStore(Request $request, $id){
		$token = $request->session()->get('token','');
		$this->setToken($token);
		$general_data = $request->only(['name','title']);
		$multipart_data = array();
		
		if($request->file('banner')){
			$multipart_data['banner']   = $request->banner;
		}
		
		$result = $this->MULTIPART(env("API_URL").'/api/votes/update-topic/'.$id,$general_data,$multipart_data);

		if($result['status'] == true)
		{
			return redirect('/dashboard/voting')->with('success', $result['message']);
		}else{
			return redirect()->back()->with('error', $result['message']);
		} 
	}

	public function topicDelete(Request $request, $id){
		$token = $request->session()->get('token','');
		$put['data'] = ['token' => $token];
		$this->setToken($token);

		$this->apiLib->setParams($put['data']);
		$result = $this->apiLib->generateDataAPI('GET','/api/votes/delete-topic/'.$id);
		if (!$result) {
			throw new \Exception("Failed to Delete Topic");
		}
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

	public function candidateFormCreate(Request $request, $id){
		$token = $request->session()->get('token');
		$put['data'] = ['token' => $token];
		
		$this->apiLib->setParams($put['data']);
		$result = $this->apiLib->generate('GET','/api/votes/topic/'.$id);
		if($result->status == true)
		{
			$data = $result->data;
			return view('one.voting.votingCandidateCreate',compact('data'));
		}else{
			return redirect()->back()->with('error', $result['message']);
		} 
	}

	public function candidateFormCreateStore(Request $request, $id){
		$token = $request->session()->get('token','');
		$this->setToken($token);
		$general_data = $request->only(['name']);
		$multipart_data = array();
		
		if($request->file('icon')){
			$multipart_data['icon']   = $request->icon;
		}

		$general_data['vote_topic_id'] = $id;
		
		$result = $this->MULTIPART(env("API_URL").'/api/votes/assign-candidate',$general_data,$multipart_data);

		if($result['status'] == true)
		{
			return redirect('/dashboard/topic/details/'.$id)->with('success', $result['message']);
		}else{
			return redirect()->back()->with('error', $result['message']);
		} 
	}

	public function candidateFormUpdate(Request $request, $id, $ch){
		$token = $request->session()->get('token');
		$put['data'] = ['token' => $token];
		
		$this->apiLib->setParams($put['data']);
		$topic = $this->apiLib->generate('GET','/api/votes/topic/'.$id);
		$choice = $this->apiLib->generate('GET','/api/votes/candidate/'.$ch);
		if($topic->status == true && $choice->status == true)
		{
			$topic = $topic->data;
			$choice = $choice->data;
			return view('one.voting.votingCandidateUpdate',compact('topic','choice'));
		}else{
			return redirect()->back()->with('error', $result['message']);
		} 
	}

	public function candidateFormUpdateStore(Request $request, $id, $ch){
		$token = $request->session()->get('token','');
		$this->setToken($token);
		$general_data = $request->only(['name']);
		$multipart_data = array();
		
		if($request->file('icon')){
			$multipart_data['icon']   = $request->banner;
		}

		$general_data['vote_topic_id'] = $id;
		
		$result = $this->MULTIPART(env("API_URL").'/api/votes/update-candidate/'.$ch,$general_data,$multipart_data);

		if($result['status'] == true)
		{
			return redirect('/dashboard/topic/details/'.$id)->with('success', $result['message']);
		}else{
			return redirect()->back()->with('error', $result['message']);
		} 
	}

	public function deleteCandidate(Request $request, $ch){
		$token = $request->session()->get('token','');
		$put['data'] = ['token' => $token];
		$this->setToken($token);

		$this->apiLib->setParams($put['data']);
		$result = $this->apiLib->generateDataAPI('GET','/api/votes/delete-candidate/'.$ch);
		if (!$result) {
			throw new \Exception("Failed to Delete Candidate");
		}
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
