@extends('one.layout.base')

@section('content')
        <div class="container-fluid">
            <div class="fade-in">
              <div class="card">
                <div class="card-header">
                      <i class="fa fa-align-justify"></i>Level List
                </div>
                <div class="card-body">
                
                <table class="table table-responsive-sm stripe" id="style_data">
                        <thead>
                          <tr>
                          <th>No</th>
                            <th>Type</th>
                            <th>Job</th>
                            <th>version</th>
                            <th>Response Status Code</th>
                            <th>Response status</th>
                            <th>Platform</th>
                            <th>IP Address</th>
                            <th>Created At</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($log as $index => $logs)
                            <tr>
                              <td>{{ $index+1 }}</td>
                              <td>{{ $logs->type }}</td>
                              <td>{{ $logs->module }}</td>
                              <td>{{ $logs->version }}</td>
                              <td>{{ $logs->status_code }}</td>
                              <td>{{ ($logs->status_code == '200')? "Success" : "Failed" }}</td>
                              <td>{{ $logs->request_header }}</td>
                              <td>{{ $logs->ip_address }}</td>
                              <td>{{ $logs->created_at }}</td>
                              <td>
                                  <a href="{{ env('APP_URL', '').'/dashboard/log/mobile-log/show/'.$logs->id }}" class="btn btn-block btn-info">Detail</a>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
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

