@extends('one.layout.base')

@section('content')
        <div class="container-fluid">
            <div class="fade-in">
              <div class="card">
                <div class="card-header">
                      <i class="fa fa-align-justify"></i>Jobs List
                </div>
                <div class="card-body">
                @if(in_array("add", $action))
                  <div class="row">
                    <div class="col-md-5">
                      <a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/jobs/create' }}"><i class="cil-plus"></i> Create Jobs</a>
                    </div>
                  </div>
                  <br>
                @endif
                <table class="table table-responsive-sm stripe" id="style_data">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Company</th>
                            <th>Job Title</th>
                            <th>Min Experience</th>
                            <th>Status</th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $index => $results)
                            <tr>
                              <td>{{ $index+1 }}</td>
                              <td>{{ $results->company->name }}</td>
                              <td>{{ $results->job_title }}</td>
                              <td>{{ $results->minimum_experience }} year</td>
                              <td>{{ ($results->status == 1)? "Active" : "Not Active" }}</td>
                              <td><a href="{{ env('APP_URL', '').'/dashboard/jobs/details/'.$results->job_id }}" class="btn btn-block btn-primary">Details</a></td>
                              <td>
                                @if(in_array("edit", $action))
                                <a href="{{ env('APP_URL', '').'/dashboard/jobs/edit/'.$results->job_id }}" class="btn btn-block btn-dark">Edit</a>
                                @endif
                              </td>
                              <td>
                                @if(in_array("delete", $action))
                                  <button class="btn btn-block btn-danger" onclick="deleteConfirmation('{{ env('APP_URL', '').'/dashboard/jobs/delete/'.$results->job_id}}')">Delete</button>
                                @endif
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

