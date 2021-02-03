@extends('one.layout.base')

@section('content')

        <div class="container-fluid">
            <div class="fade-in">
              <div class="card">
                <div class="card-header">
                      <i class="fa fa-align-justify"></i>Role List
                </div>
                <div class="card-body">
                @if(in_array("add", $action))
                  <div class="row">
                    <div class="col-md-5">
                      <a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/settings/roles/create' }}"><i class="cil-plus"></i> Create Role</a>
                    </div>
                  </div>
                  <br>
                @endif
                <table class="table table-responsive-sm stripe" id="style_data">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Name Level</th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($data->data as $index => $results)
                            <tr>
                              <td>{{ $index+1 }}</td>
                              <td>{{ $results->role_name }}</td>
                              <td>
                              @if(in_array("view", $action))
                                <a href="{{ env('APP_URL', '').'/dashboard/settings/roles/view/'.$results->role_id }}" class="btn btn-block btn-info">View</a>
                              @endif
                              </td>
                              <td>
                              @if(in_array("edit", $action))
                                <a href="{{ env('APP_URL', '').'/dashboard/settings/roles/edit/'.$results->role_id }}" class="btn btn-block btn-dark">Edit</a>
                              @endif
                              </td>
                              <td>
                              @if(in_array("delete", $action))
                              <button class="btn btn-block btn-danger" onclick="deleteConfirmation({{ env('APP_URL', '').'/dashboard/settings/roles/delete'.$results->role_id }})">Delete</button>
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

