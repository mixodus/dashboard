@extends('one.layout.base')

@section('content')
        <div class="container-fluid">
            <div class="fade-in">
              <div class ="row">
                <div class="col-sm-4">
                    <div class="card">
                      <!-- <div class="card-header">
                            <i class="fa fa-align-justify"></i>Admin List
                      </div> -->
                      <div class="card-body">
                        <div class="row justify-content-center">
                          <img class="c-avatar-img2" src="http://localhost/new-one-dashboard/public/assets/image/icon.png" alt="user@email.com">
                        </div>
                        </br>
                        <div class="row justify-content-center">
                          <label><h5>{{$data->fullname}}</h5></label>
                        </div>
                        <div class="row justify-content-center">
                          <label>{{$data->job_title}}</label>
                        </div>     
                    </div>
                  </div>
                </div>
                <div class="col-sm-8">
                    <div class="card">
                      <div class="card-header">
                            <i class="fa fa-align-justify"></i>Description Employee
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-12">
                            <label><b>Event History</b></label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            @foreach($data->history as $historys)
                              <label>{{$historys->event_done}}</label>
                              <span class="help-block">Event</span>
                              <label>{{$historys->bootcamp_done}}</label>
                              <span class="help-block">Bootcamp</span>
                              <label>{{$historys->challenge_done}}</label>
                              <span class="help-block">Challenge</span>
                            @endforeach
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <label><b>Skill</b></label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <label>{{$data->skill_text}}</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <label><b>Experience</b></label>
                          </div>
                        </div>
                        <div class="row">
                          @foreach($data->work_experience as $experiences)
                          <div class="col-sm-12">
                            
                              <label>- {{$experiences->company_name}}</label>
                           
                          </div>
                          @endforeach
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <label><b>Education</b></label>
                          </div>
                        </div>
                        <div class="row">
                         @foreach($data->qualification as $qualifications)
                          <div class="col-sm-12">
                            <label>- {{$qualifications->name}}</label>
                          </div>
                         @endforeach
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <label><b>Project</b></label>
                          </div>
                        </div>
                        <div class="row">
                          @foreach($data->project as $projects)
                            <div class="col-sm-12">
                              <label>- {{$projects->project_name}}</label>
                            </div>
                          @endforeach
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <label><b>Certification</b></label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <label>{{$data->skill_text}}</label>
                          </div>
                        </div>
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
    <style>
      .c-avatar-img2 {
        width: 50%;
        height: auto;
        border-radius: 50em;
      }
    </style>
@endsection

