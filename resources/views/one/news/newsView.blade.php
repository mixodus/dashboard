@extends('one.layout.base')

@section('content')
        <div class="container-fluid">
            <div class="fade-in">
            @if ($errors->any())
                <div class="alert alert-danger" id="divMessages">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="text-center">
                            <h1><b>{{$data_news->news_title}}</b></h1>
                          </div>
                        </div>
                      </div>
                      </br>
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="text-center">
                            <img src="{{$data_news->news_photo_url}}" class="img-fluid images" alt="Responsive image">
                          </div>
                          <!-- <img src="http://localhost/new-one-dashboard/public/assets/image/no_image.png" class="rounded mx-auto d-block" alt="..."> -->
                        </div>
                      </div>
                      </br>
                      <div class="row">
                        <div class="col-sm-12">
                          {!! $data_news->news_details !!}
                        </div>
                      </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i>Comment</div>
                    <div class="card-body">
                      @foreach($data_news->comments as $key => $comment)
                      <div class="display-comment">
                          <strong>{{ $comment->user->fullname}}</strong> <small> Posted on <i>{{ $comment->created_at}}</i></small>
                          <p>{{ $comment->comment}}</p>
                              <div class="form-group">
                                  <input type="text" name="comment" class="form-control" id="comment-{{$comment->comment_id}}" required="" />
                                  <input type="hidden" name="comment_id" class="form-control" id="comment_id"  value="{{$comment->comment_id}}"/>
                                  <input type="hidden" name="news_id" class="form-control" id="news_id"  value="{{$data_news->news_id}}"/>
                              </div>
                              <div>
                                  <button class="btn btn-sm btn-dark reply" data-id="{{$comment->comment_id}}">Reply</button>
                                  <button class="btn btn-sm btn-danger" onclick="deleteConfirmation('{{ env('APP_URL', '').'/dashboard/news-article/deletecomment/'.$comment->comment_id }}')">Delete</button>
                              </div>
                          </br>
                          @foreach($comment->comment_replies as $key => $sub_comment)
                            <div class="display-comment" style="margin-left:40px;">
                              <div class="card">
                                <div class="card-body">
                                  <strong>{{$sub_comment->user->fullname}}</strong> <small> Posted on <i>{{ $sub_comment->created_at}}</i></small>
                                  <p>{{$sub_comment->comment}}</p>
                                    <div class="form-group">
                                      <button class="btn btn-sm btn-danger delete" onclick="deleteConfirmation('{{ env('APP_URL', '').'/dashboard/news-article/del-replycomment/'.$sub_comment->reply_id }}')">Delete</button>
                                    </div>
                                </div>
                              </div>
                            </div>
                          @endforeach
                      </div>
                      @endforeach
                      <hr />
                    <h4>Add comment</h4>
                    <form method="POST" action="{{ env('APP_URL', '').'/dashboard/news-article/addcomment' }}">
                      {{ csrf_field() }}
                        <div class="form-group">
                            <textarea class="form-control" name="comment" placeholder="Typing comment.." required></textarea>
                            <input type="hidden" name="news_id" value="{{$data_news->news_id}}" />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-sm btn-success" value="Add Comment" />
                            <a href="{{ env('APP_URL', '').'/dashboard/news-article' }}" class="btn btn-sm btn-danger" type="button"> Cancel</a>
                        </div>
                    </form>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
                    
@endsection


@section('javascript')
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script>
      $(document).on("click", ".reply" , function() {

          var id = $(this).data("id");
          var comment = $('#comment-'+id).val();
          var comment_id = $('#comment_id').val();
          var news_id = $('#news_id').val();
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          if(comment){
              $.ajax({
                url: "{{url('/dashboard/news-article/replycomment')}}",
                type: 'post',
                data: {_token: CSRF_TOKEN, comment: comment,comment_id: comment_id,news_id:news_id},
                success: function(response){
                  if(response.success === true){
                      window.location.reload();
                  }
                }
              });
          }else{
            $('#comment-'+id).after('<small class="text-danger">Comment not required!!</small>');
          }
      });
    </script>
    <style>
      .file {
              visibility: hidden;
              position: absolute;
            }
      .images {
        width: 60%;
        height: auto;
        border-radius: 5px;
      }
      .display-comment {
            border: 5px;
        }
    </style>
@endsection

