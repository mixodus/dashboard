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
                            <th>Fullname</th>
                            <th>E-mail</th>
                            <th>Level</th>
                            <th>Point</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $index => $results)
                            <tr>
                              <td>{{ $index+1 }}</td>
                              <td>{{ $results->fullname }}</td>
                              <td>{{ $results->email }}</td>
                              <td>{{ $results->level->level_name }}</td>
                              <td>{{ $results->point }}</td>
                              <td>
                                  <a href="{{ env('APP_URL', '').'/dashboard/user-management/employee-level/view/'.$results->user_id }}" class="btn btn-block btn-info">View</a>
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

