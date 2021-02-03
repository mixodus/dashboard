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
                            <h1><b>{{$data_event->event_title}}</b></h1>
                          </div>
                        </div>
                      </div>
                      </br>

                      <div class="row">
                        <div class="col-sm-12">
                          <ul class="list-group">
                            <li class="list-group"><span class="data-event">Date : {{ date('d F Y',strtotime($data_event->event_date)) }}</span></li>
                            <li class="list-group"><span class="data-event">Time : {{ $data_event->event_time }}</span></li>
                            <li class="list-group"><span class="data-event">Location : {{ $data_event->event_place }}</span></li>
                          </ul>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="text-center">
                            <img src="{{$data_event->event_banner_url}}" class="img-fluid images" alt="Responsive image">
                          </div>
                        </div>
                      </div>
                      </br>
                      <div class="row">
                        <div class="col-sm-12">
                          {!! $data_event->event_note !!}
                        </div>
                      </div>

                      <div class="entry-meta post-atribute mb-3 small text-muted">
            
                        <span class="byline"><span class="fa fa-user"></span> Speaker by :<span class="author vcard" style="color: #66ff33"> <b>{{ $data_event->event_speaker }} </b></span></span>
                        
                  
                      </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i>Participant</div>
                    <div class="card-body">
                      <table class="table table-responsive-sm stripe" id="style_data">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($data_event->participants as $index => $participant)
                            <tr>
                              <td>{{ $index+1 }}</td>
                              <td>{{ $participant->fullname }}</td>
                              <td>{{ $participant->email }}</td>
                              <td>{{ $participant->status }}</td>
                              <td>
                              @if($participant->status != "Approved")
                                <form method="POST" action="{{ env('APP_URL', '').'/dashboard/event/register-status/'.$participant->id }}">
                                  @csrf
                                  <input type="submit" class="btn btn-success" name="status" value="Approved">
                                </form>
                              </td>
                              @endif
                            </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                    <div class="card-footer">
                      <a href="{{ env('APP_URL', '').'/dashboard/event' }}" class="btn btn-sm btn-danger" type="button"> Cancel</a>
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
      .data-event {
        font-size : 120%;
      }
    </style>
@endsection

