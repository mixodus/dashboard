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
              <div class="card">
                <div class="card-header">
                      <i class="fa fa-align-justify"></i>Create Freelance
                </div>
                <div class="card-body">
                <div class="row">
                    <div class="col-12">
                    <form method="POST" action="{{ env('APP_URL', '').'/dashboard/freelancer/adminupdate/'.$data->referral_id }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                      <label><b>Name :</b></label>
                      <input class="form-control" name="referral_name" type="text" placeholder="Freelancer Name" value="{{$data->referral_name}}" required>
                      <br>
                      <label><b>Email :</b></label>
                      <input class="form-control" name="referral_email" type="text" placeholder="Freelancer Email" value="{{$data->referral_email}}" required>
                      <br>
                      <label><b>Contact Number:</b></label>
                      <input class="form-control" name="referral_contact_no" type="number" placeholder="Freelancer's Phone Number" value="{{$data->referral_contact_no}}" required>
                      <br>
                      <label><b>Upload CV:</b></label>
                      <input class="form-control-file" name="file" type="file" placeholder="Uplaod CV" value="{{$data->file}}"> 
                      <b>See your pervious CV: <a href ="{{ $data->file_url }}" target="_blank">Click Here!</a></b>
                      <p>Leave the file upload empty if you don't want to change your CV!</p>
                      <br>
                      <label><b>Fee:</b></label>
                      <input class="form-control" name="fee" type="number" placeholder="Fees" value="{{$data->fee}}" required>
                      <br>
                      <label><b>Job-Position:</b></label>
                      <input class="form-control" name="job_position" type="text" placeholder="Job Position" value="{{$data->job_position}}" required>
                      <br>
                      <div class="card-footer">
                        <button class="btn btn-sm btn-primary" type="submit"> Submit</button>
                        <a href="{{ env('APP_URL', '').'/dashboard/user-management/admin' }}" class="btn btn-sm btn-danger" type="button"> Cancel</a>
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
@endsection
