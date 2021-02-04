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
              <div class ="row">
                <div class="col-sm-12">
                    <div class="card">
                      <div class="card-header">
                            <i class="fa fa-align-justify"></i>Edit Employee
                      </div>
                      <div class="card-body">
                        <form method="POST" action="{{ env('APP_URL', '').'/dashboard/user-management/employee/update/'.$data->user_id }}">
                          @csrf
                          @method('PUT')
                           
                            <div class="row">
                              <div class="col-sm-6">
                                <label><b>Fullname :</b></label>
                                <input class="form-control" name="fullname" type="text" placeholder="Fullname" value="{{$data->fullname}}" required>
                              </div>
                              <div class="col-sm-6">
                                <label><b>Date of Birth :</b></label>
                                <!-- <input class="form-control" type="date" name="date_of_birth" value="{{$date}}">                             -->
                                <input class="form-control" type="date" id="start" name="date_of_birth" value="{{$date}}" min="1950-01-01">
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <label><b>Gender :</b></label>
                                <select class="form-control" name="gender" required>
                                  <option name="gender" value="Male" {{ ( $data->gender == 'Male' ) ? 'selected' : '' }}>Male</option>
                                  <option name="gender" value="Female" {{ ( $data->gender == 'Female' ) ? 'selected' : '' }}>Female</option>
                                </select>
                              </div>
                              <div class="col-sm-6">
                                <label><b>Marital Status :</b></label>
                                <select class="form-control" name="marital_status" required>
                                  <option name="marital_status" value="Married" {{ ( $data->marital_status == 'Married' ) ? 'selected' : '' }}>Married</option>
                                  <option name="marital_status" value="Single" {{ ( $data->marital_status == 'Single' ) ? 'selected' : '' }}>Single</option>
                                </select>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <label><b>Address :</b></label>
                                <textarea class="form-control" name="address" rows="3" placeholder="Address..">{{$data->address}}</textarea>
                              </div>
                              <div class="col-sm-6">
                                <label><b>Country :</b></label>
                                <select class="form-control" name="country" required>
                                  <option name="country" value="Indonesia">Indonesia</option>
                                  <option name="country" value="Amerika">Amerika</option>
                                </select>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <label><b>Province :</b></label>
                                <input class="form-control" name="province" type="text" placeholder="Province" value="{{$data->province}}" required>
                              </div>
                              <div class="col-sm-6">
                                <label><b>Zip Code :</b></label>
                                <input class="form-control" name="zip_code" type="text" placeholder="Zip Code" value="{{$data->zip_code}}" required>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <label><b>Phone Number :</b></label>
                                <input class="form-control" name="contact_no" type="text" placeholder="Phone Number" value="{{$data->contact_no}}" required>
                              </div>
                              <div class="col-sm-6">
                                <label><b>Number NPWP :</b></label>
                                <input class="form-control" name="npwp" type="text" placeholder="No NPWP" value="{{$data->npwp}}" required>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <label><b>Job :</b></label>
                                <select class="form-control" name="job_title" required>
                                  <option name="job_title" value="Sofware">Software</option>
                                  <option name="job_title" value="HR">HR</option>
                                </select>
                              </div>
                              <div class="col-sm-6">
                                <label><b>Summary :</b></label>
                                <textarea class="form-control" name="summary" rows="2" placeholder="Summary..">{{$data->summary}}</textarea>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <label><b>Status :</b></label>
                                <select class="form-control" name="is_active" required>
                                  <option name="is_active" value="1" {{ ( $data->is_active == 1 ) ? 'selected' : '' }}>Active</option>
                                  <option name="is_active" value="0" {{ ( $data->is_active == 0 ) ? 'selected' : '' }}>Not Active</option>
                                </select>
                              </div>
                            </div>
                      </div>
                      <div class="card-footer">
                        <button class="btn btn-sm btn-primary" type="submit"> Submit</button>
                        <a href="{{ env('APP_URL', '').'/dashboard/user-management/employee' }}" class="btn btn-sm btn-danger" type="button"> Cancel</a>
                      </div>
                    </div>
                    </form>
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

