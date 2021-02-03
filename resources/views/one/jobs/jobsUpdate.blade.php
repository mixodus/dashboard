@extends('one.layout.base')

@section('content')
        <div class="container-fluid">
            <div class="fade-in">
            @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <button type="button" class="close" data-dismiss="alert">×</button>
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
            <form method="POST" action="{{ env('APP_URL', '').'/dashboard/jobs/update/'.$data_job->job_id}}">
              @csrf
              @method('PUT')
              <div class="row">
             
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i>Job Company</div>
                    <div class="card-body">
                        <div class="col-sm-12">
                          <label><b>Company :</b></label>
                          <select class="form-control" name="company_id" required>
                            <option name="company_id" value="0">-- Select Company --</option>
                            @foreach($data_company as $company)
                            <option name="company_id" value="{{$company->company_id}}" {{ ( $data_job->company_id == $company->company_id ) ? 'selected' : '' }}>{{$company->name}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-sm-12">
                          <label><b>Job Title :</b></label>
                          <input class="form-control" name="job_title" type="text" placeholder="Input title" value="{{$data_job->job_title}}" required>
                        </div>
                    </div>

                </div>

                <div class="card">
                  <div class="card-header"><i class="fa fa-align-justify"></i>Job Details</div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-6">
                          <label><b>Job Type :</b></label>
                            <select class="form-control" name="job_type" required>
                              <option name="job_type" value="0">-- Select job type --</option>
                              <option name="job_type" value="1" {{ ( $data_job->job_type == 1 ) ? 'selected' : '' }}>Full Time</option>
                              <option name="job_type" value="2" {{ ( $data_job->job_type == 2 ) ? 'selected' : '' }}>Intership</option>
                              <option name="job_type" value="3" {{ ( $data_job->job_type == 3 ) ? 'selected' : '' }}>Freelance</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                          <label><b>Job Designation :</b></label>
                          <input class="form-control" name="designation_id" type="text" placeholder="Input designation" value="{{$data_job->designation_id}}" required>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <label><b>Job Vacancy :</b></label>
                          <input class="form-control" name="job_vacancy" type="text" placeholder="Input vacancy" value="{{$data_job->job_vacancy}}" required>
                        </div>
                        <div class="col-sm-6">
                          <label><b>Min Experience :</b></label>
                          <input class="form-control" name="minimum_experience" type="text" placeholder="input min experience" value="{{$data_job->minimum_experience}}" required>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <label><b>Gender :</b></label>
                            <select class="form-control" name="gender" required>
                              <option name="gender" value="0">-- Select gender --</option>
                              <option name="gender" value="1" {{ ( $data_job->gender == 1 ) ? 'selected' : '' }}>Male</option>
                              <option name="gender" value="2" {{ ( $data_job->gender == 2 ) ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                        <label><b>Date Close :</b></label>
                          <input class="form-control" name="date_of_closing" type="date" value="{{$date}}" required>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <label><b>Job Status :</b></label>
                            <select class="form-control" name="status" required>
                              <option name="status" value="">-- Select status --</option>
                              <option name="status" value="1" {{ ( $data_job->status == 1 ) ? 'selected' : '' }}>Active</option>
                              <option name="status" value="0" {{ ( $data_job->status == 0 ) ? 'selected' : '' }}>Non Active</option>
                            </select>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i>Job Position</div>
                      <div class="card-body">

                        <div class="row">
                          <div class="col-sm-12">
                            <label><b>Country :</b></label>
                            <select class="form-control" name="country" required>
                              <option name="country" value="-">-- Select Country --</option>
                              @foreach($data_country as $country)
                              <option name="country" value="{{$country->country_code}}" {{ ( $data_job->country == $country->country_code ) ? 'selected' : '' }}>{{$country->country_name}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-12">
                            <label><b>Province :</b></label>
                            <select class="form-control" name="province" id="province" required>
                              <option name="province" value="-">-- Select Province --</option>
                              @foreach($data_province as $province)
                              <option name="province" value="{{$province->id_prov}}" {{ ( $data_job->province == $province->id_prov ) ? 'selected' : '' }}>{{$province->name}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-12">
                            <label><b>City :</b></label>
                            <select class="form-control" name="city_id" required>
                            @foreach($data_city as $city)
                              <option name="city_id" value="{{$city->city_id}}" {{ ( $data_job->city_id == $city->city_id ) ? 'selected' : '' }}>{{$city->name}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                      </div>
                </div>


                <div class="card">
                  <div class="card-header"><i class="fa fa-align-justify"></i>Salary Information</div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-6">
                          <label><b>Currency :</b></label>
                           <select class="form-control" name="currency_id" required>
                              <option name="currency_id" value="2">-- Select currency --</option>
                              <option name="currency_id" value="1" {{ ( $data_job->currency_id == 1 ) ? 'selected' : '' }}>Dollar</option>
                              <option name="currency_id" value="2" {{ ( $data_job->currency_id == 2 ) ? 'selected' : '' }}>Rupiah</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                          <label><b>Salary Description :</b></label>
                          <input class="form-control" name="salary_desc" type="text" placeholder="Input Description" value="{{$data_job->salary_desc}}" required>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <label><b>Salary Start :</b></label>
                          <input class="form-control" onkeypress="return number(event)" name="salary_start" type="text" placeholder="Input min salary" value="{{$data_job->salary_start}}" required>
                        </div>
                        <div class="col-sm-6">
                          <label><b>Salary End :</b></label>
                          <input class="form-control salary" onkeypress="return number(event)" name="salary_end" type="text" placeholder="Input max salary" value="{{$data_job->salary_end}}" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <label><b>Salary Show :</b></label>
                          <input class="form-control salary" onkeypress="return number(event)" name="show_salary" type="text" placeholder="Fullname" value="{{$data_job->show_salary}}" required>
                        </div>
                    </div>
                    </div>

                    

                </div>
            </div>

            <div class="col-md-12">
                  <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i>Job Description</div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-6">
                          <label><b>Short Description :</b></label>
                          <textarea class="form-control" name="short_description" rows="5" placeholder="Typing short description..">{{$data_job->short_description}}</textarea>
                        </div>

                        <div class="col-sm-6">
                          <label><b>Long Description :</b></label>
                          <textarea class="form-control" name="long_description" rows="5" placeholder="Typing Long description..">{{$data_job->long_description}}</textarea>
                        </div>
                      </div>

                        
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-sm btn-primary" type="submit"> Submit</button>
                        <a href="{{ env('APP_URL', '').'/dashboard/jobs' }}" class="btn btn-sm btn-danger" type="button"> Cancel</a>
                      </div>
                    </div>
                </div>
                
            </form>
            </div>
        </div>
                    
@endsection


@section('javascript')
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('select[name="province"]').on('change', function() {
            var provID = $(this).val();
            if(provID) {
                $.ajax({
                    url: "{{url('/dashboard/location/city/show')}}/"+provID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="city_id"]').empty();
                        $.each(data, function(key, value) {
                          value.forEach(function(value) {
                            $('select[name="city_id"]').append('<option value="'+ value.city_id +'">'+ value.name +'</option>');
                          });
                        });
                    }
                });
            }else{
                $('select[name="city_id"]').empty();
            }
        });       
      });

      function number(evt) {
          var charCode = (evt.which) ? evt.which : event.keyCode
          if (charCode > 31 && (charCode < 48 || charCode > 57))
      
          return false;
          return true;
      }
    </script>
@endsection

