<?php

namespace App\Http\Controllers\one\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\One\ApiLibrary;

class NewsController extends Controller
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
        $result = $this->apiLib->generate('GET', '/api/news-dashboard');

        if (!empty($result->status)) {
            $data = $result->data;
            $action = $result->action->original;

            return view('one.news.newsList', compact('data', 'action'));
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

            $result = $this->apiLib->generate('GET', '/api/news-type');
            if (!$result) {
                throw new \Exception("Failed get news type");
            }

            $data_type = $result->data;

            return view('one.news.newsCreate', compact('data_type'));
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
            'news_title' => 'required',
            'news_type_id' => 'required',
            'news_details' => 'required',
            'news_photo' => "required|image|mimes:jpg,png,jpeg|max:5000"
        ]);

        $multipart_data = array();
        $multipart_data['news_photo']    = $request->news_photo;

        foreach ($multipart_data as $key => $file) {
            $data[] = [
                'name'      => $key,
                'contents'  => fopen($file->getPathname(), 'r'),
                'filename'  => $file->getClientOriginalName()
            ];
        }

        $data[] = [
            'name' => 'news_title',
            'contents' => $request->news_title
        ];
        $data[] = [
            'name' => 'news_type_id',
            'contents' => $request->news_type_id
        ];
        $data[] = [
            'name' => 'news_details',
            'contents' => $request->news_details
        ];
        $data[] = [
            'name' => 'news_url',
            'contents' => $request->news_url
        ];

        $this->apiLib->setToken($token);
        $this->apiLib->setParams($data);
        $result = $this->apiLib->generateUpload('POST', '/api/news-create');

        if (!empty($result->status)) {
            return redirect('/dashboard/news-article')->with('success', $result->message);
        } else {
            return redirect('/dashboard/news-article/create')->with('error', $result->message);
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
        $put['data'] = ['token' => $token, 'byNewsid' => $id];
        try {
            $this->apiLib->setParams($put['data']);

            $result = $this->apiLib->generate('GET', '/api/news-show');
            if (!$result) {
                throw new \Exception("Failed get news type");
            }

            $data_news = $result->data[0];

            return view('one.news.newsView', compact('data_news'));
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
        $put['data'] = ['token' => $token, 'byNewsid' => $id];
        try {
            $this->apiLib->setParams($put['data']);

            $result = $this->apiLib->generate('GET', '/api/news-show');
            if (!$result) {
                throw new \Exception("Failed get news type");
            }

            $news_type = $this->apiLib->generate('GET', '/api/news-type');
            if (!$news_type) {
                throw new \Exception("Failed get news type");
            }

            $data_type = $news_type->data;
            $data_news = $result->data[0];

            return view('one.news.newsUpdate', compact('data_news', 'data_type'));
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
            'news_title' => 'required',
            'news_type_id' => 'required',
            'news_details' => 'required',
            'news_photo' => "image|mimes:jpg,png,jpeg|max:5000"
        ]);

        $multipart_data = array();
        $multipart_data['news_photo']    = $request->news_photo;

        if (!empty($request->news_photo)) {
            foreach ($multipart_data as $key => $file) {
                $data[] = [
                    'name'      => $key,
                    'contents'  => fopen($file->getPathname(), 'r'),
                    'filename'  => $file->getClientOriginalName()
                ];
            }
        }

        $data[] = [
            'name' => 'news_title',
            'contents' => $request->news_title
        ];
        $data[] = [
            'name' => 'news_type_id',
            'contents' => $request->news_type_id
        ];
        $data[] = [
            'name' => 'news_details',
            'contents' => $request->news_details
        ];
        $data[] = [
            'name' => 'news_url',
            'contents' => $request->news_url
        ];

        $this->apiLib->setToken($token);
        $this->apiLib->setParams($data);
        $result = $this->apiLib->generateUpload('POST', '/api/news-update?byNewsid=' . $id);

        if (!empty($result->status)) {
            return redirect('/dashboard/news-article')->with('success', $result->message);
        } else {
            return redirect('/dashboard/news-article/create')->with('success', $result->message);
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
        $result = $this->apiLib->generate('delete', '/api/news-delete?byNewsid=' . $id);

        if (!empty($result->status)) {
            $success = true;
            $message = $result->message;
        } else {
            $success = false;
            $message = $result->message;
        }

        return response()->json(['success' => $success, 'message' => $message]);
    }

    public function addcomment(Request $request)
    {
        $token = $request->session()->get('token');
        $validated = $request->validate([
            'comment' => "required|string",
        ]);

        $data = [
            'news_id' => $request->news_id,
            'comment' => $request->comment,
            'token' => $token
        ];

        try {
            $this->apiLib->setParams($data);
            $result = $this->apiLib->generate('POST', '/api/news-comment');

            if (!empty($result->status)) {
                return redirect()->back()->with('success', $result->message);
            }
        } catch (\Exception $e) {
            $err_messages = $e->getMessage();
            return view('one.errors.errors', compact('err_messages'));
        }
    }

    public function replycomment(Request $request)
    {
        $token = $request->session()->get('token');
        $validated = $request->validate([
            'comment'       => "required|string",
            'comment_id'    => "required",
            'comment'       => "required|string"
        ]);

        $data = [
            'comment_id'   => $request->comment_id,
            'comment'      => $request->comment,
            'token'        => $token
        ];

        try {
            $this->apiLib->setParams($data);
            $result = $this->apiLib->generate('POST', '/api/news-reply-comment');

            if (!empty($result->status)) {
                toast('Success add reply comment', 'success');
                $success = true;
                return response()->json(['success' => $success]);
            }
        } catch (\Exception $e) {
            $err_messages = $e->getMessage();
            return view('one.errors.errors', compact('err_messages'));
        }
    }

    public function deletecomment(Request $request, $id)
    {
        $token = $request->session()->get('token');
        $data = ['token' => $token];

        try {
            $this->apiLib->setParams($data);
            $result = $this->apiLib->generate('delete', '/api/news-comment-delete?byComment_id=' . $id);

            if (!empty($result->status)) {
                $success = true;
                $message = $result->message;
            } else {
                $success = false;
                $message = $result->message;
            }

            return response()->json(['success' => $success, 'message' => $message]);
        } catch (\Exception $e) {
            $err_messages = $e->getMessage();
            return view('one.errors.errors', compact('err_messages'));
        }
    }

    public function deletereplycomment(Request $request, $id)
    {
        $token = $request->session()->get('token');
        $data = ['token' => $token];

        try {
            $this->apiLib->setParams($data);
            $result = $this->apiLib->generate('delete', '/api/news-repcomment-delete?byReply_id=' . $id);

            if (!empty($result->status)) {
                $success = true;
                $message = "Reply comment deleted successfully";
            } else {
                $success = false;
                $message = "Delete Reply comment filed";
            }

            return response()->json(['success' => $success, 'message' => $message]);
        } catch (\Exception $e) {
            $err_messages = $e->getMessage();
            return view('one.errors.errors', compact('err_messages'));
        }
    }
}
