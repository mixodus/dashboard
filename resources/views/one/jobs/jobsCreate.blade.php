@extends('one.layout.base')

@section('content')
        <div class="container-fluid">
            <div class="fade-in">
            <form method="POST" action="{{ env('APP_URL', '').'/dashboard/jobs/store'}}">
              @csrf
              @method('POST')
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
                            <option name="company_id" value="{{$company->company_id}}">{{$company->name}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-sm-12">
                          <label><b>Job Title :</b></label>
                          <input class="form-control" name="job_title" type="text" placeholder="Input title" required>
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
                              <option name="job_type" value="1">Full Time</option>
                              <option name="job_type" value="2">Intership</option>
                              <option name="job_type" value="3">Freelance</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                          <label><b>Job Designation :</b></label>
                          <input class="form-control" name="designation_id" type="text" placeholder="Input designation" required>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <label><b>Job Vacancy :</b></label>
                          <input class="form-control" name="job_vacancy" type="text" placeholder="Input vacancy" required>
                        </div>
                        <div class="col-sm-6">
                          <label><b>Min Experience :</b></label>
                          <input class="form-control" name="minimum_experience" type="text" placeholder="input min experience" required>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <label><b>Gender :</b></label>
                            <select class="form-control" name="gender" required>
                              <option name="gender" value="0">-- Select gender --</option>
                              <option name="gender" value="1">Male</option>
                              <option name="gender" value="2">Female</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                        <label><b>Date Close :</b></label>
                          <input class="form-control" name="date_of_closing" type="date" required>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <label><b>Job Status :</b></label>
                            <select class="form-control" name="status" required>
                              <option name="status" value="">-- Select status --</option>
                              <option name="status" value="1">Active</option>
                              <option name="status" value="0">Non Active</option>
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
                              <option name="country" value="{{$country->country_code}}">{{$country->country_name}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-12">
                            <label><b>Province :</b></label>
                            <select class="form-control" name="province" required>
                              <option name="province" value="-">-- Select Province --</option>
                              @foreach($data_province as $province)
                              <option name="province" value="{{$province->id_prov}}">{{$province->name}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-12">
                            <label><b>City :</b></label>
                            <select class="form-control" name="city_id" required>
                              <option name="city_id" value="-">-- Select Province --</option>
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
                              <option name="currency_id" value="1">Dollar</option>
                              <option name="currency_id" value="2">Rupiah</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                          <label><b>Salary Description :</b></label>
                          <input class="form-control" name="salary_desc" type="text" placeholder="Input Description" required>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <label><b>Salary Start :</b></label>
                          <input class="form-control" name="salary_start" type="text" placeholder="Input min salary" required>
                        </div>
                        <div class="col-sm-6">
                          <label><b>Salary End :</b></label>
                          <input class="form-control" name="salary_end" type="text" placeholder="Input max salary" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <label><b>Salary Show :</b></label>
                          <input class="form-control" name="show_salary" type="text" placeholder="Fullname" required>
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
                          <textarea class="form-control" name="short_description" rows="5" placeholder="Typing short description.."></textarea>
                        </div>

                        <div class="col-sm-6">
                          <label><b>Long Description :</b></label>
                          <textarea class="form-control" name="long_description" rows="5" placeholder="Typing Long description.."></textarea>
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
                            console.log(value.name);
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
    </script>
@endsection

