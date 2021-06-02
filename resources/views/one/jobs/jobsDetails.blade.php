@extends('one.layout.base')

@section('content')
        <div class="container-fluid">
            <div class="fade-in">
            <div class="card">
                <div class="card-header">
                      <i class="fa fa-align-justify"></i>Job Details
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label><b>Company </b></label>
                        </div>
                        <div class="col-md-10">{{$data_company->name}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label><b>Job Status </b></label>
                        </div>
                        @if($data_job->status == 1)
                        <div class="col-md-10">Active </div>
                        @else
                        <div class="col-md-10">Not Active</div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label><b>Title </b></label>
                        </div>
                        <div class="col-md-10">{{$data_job->job_title}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label><b>Position </b></label>
                        </div>
                        <div class="col-md-10">{{$data_country->country_name}}, {{$data_province->name}}, {{$data_city->name}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label><b>Description </b></label>
                        </div>
                        <div class="col-md-10">{{$data_job->short_description}} <br><br></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label><b>Details </b></label>
                        </div>
                        <div class="col-md-10">{{$data_job->job_type_name}}, Slot({{$data_job->job_vacancy}}), Min Experience({{$data_job->minimum_experience}})Year</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label><b>Salary </b></label>
                        </div>
                        <div class="col-md-10">IDR {{$data_job->salary_start}} - IDR {{$data_job->salary_end}}, @if($data_job->salary_desc == null) - @else {{$data_job->salary_desc}} @endif</div>
                    </div>
                </div>
            </div>
                <!--=======================================================================-->
              <div class="card">
                <div class="card-header">
                      <i class="fa fa-align-justify"></i>Participant
                </div>
                <div class="card-body">
                <table class="table table-responsive-sm stripe" id="style_data">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact No</th>
                                        <th>Application Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data_participant as $index => $participant)
                                        <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $participant->fullname }}</td>
                                        <td>{{ $participant->email }}</td>
                                        <td>{{ $participant->contact_no }}</td>
                                        <td>{{ $participant->application_status }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                </table>
                </div>
                <div class="card-footer">
					<a href="{{ env('APP_URL', '').'/dashboard/jobs' }}" class="btn btn-sm btn-danger" type="button">Back</a>
				</div>
              </div>
            </div>
          </div>
                    
@endsection


@section('javascript')
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection

