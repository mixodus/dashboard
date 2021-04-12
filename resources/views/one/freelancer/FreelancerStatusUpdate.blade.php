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
                      <i class="fa fa-align-justify"></i>Candidate's Status
                </div>
                <div class="card-body">
                <div class="row">
                    <div class="col-12">
                    <form method="POST" action="{{ env('APP_URL', '').'/dashboard/freelancer/update/'.$data->referral_id.'/status'}}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                      <label for="referral_status"><b>Update Status :</b></label>
                        <select class="form-control" name="referral_status" required>
                          <option name="status" value="Success" {{ ( $data->referral_status == 'Success' ) ? 'selected' : '' }}>Success</option>
                          <option name="status" value="Failed" {{ ( $data->referral_status == 'Failed' ) ? 'selected' : '' }}>Failed</option>
                          <option name="status" value="InReview" {{ ( $data->referral_status == 'InReview' ) ? 'selected' : '' }}>InReview</option>
                          <option name="status" value="Pending" {{ ( $data->referral_status == 'Pending' ) ? 'selected' : '' }}>Pending</option>
                        </select>
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
