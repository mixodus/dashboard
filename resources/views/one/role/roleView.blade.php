@extends('one.layout.base')

@section('content')

        <div class="container-fluid">
            <div class="fade-in">
              @if($message = Session::get('error'))
              <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $message }}</strong>
              </div>
              @endif
              <div class="card">
                <div class="card-header">
                      <i class="fa fa-align-justify"></i>Edit Role
                </div>
                <div class="card-body">
                <div class="row">
                    <div class="col-12">
                      <label><b>Name Role :</b></label>
                      <!-- @foreach($data as $datas) -->
                                            <input 
                                                class="form-control" 
                                                name="role_id" 
                                                value = "{{ $data[0]->role_name }}"
                                                type="text" 
                                                placeholder="Name Role"
                                                readonly
                                            >
                      <!-- @endforeach -->
                      <br>
                      <label><b>Role Permission :</b></label>
                      <table class="table table-responsive-sm table-striped">
                        <thead>
                          <tr>
                            <th>Name Permisson</th>
                            <th>Group Name</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($permission as $permissions)
                            <tr>
                              <td>{{ $permissions->name }}</td>
                              <td>{{ $permissions->group_name }}</td>
                              <td>
                              @foreach($permissions->action as $actions)
                                <div class="form-check checkbox">
                                  @if(in_array($actions->id, $role_permission))
                                    <input class="form-check-input" name="action[]" type="checkbox" checked value="{{ $actions->menu_id.'-'.$actions->action }}"  readonly>
                                    {{$actions->action}}
                                  @else
                                    <input class="form-check-input" name="action[]" type="checkbox" value="{{ $actions->menu_id.'-'.$actions->action }}" readonly>
                                    {{$actions->action}}
                                  @endif
                                </div>
                                @endforeach
                              </td>
                            </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                </div>
                </div>
                <div class="card-footer">
                  <a href="{{ env('APP_URL', '').'/dashboard/settings/roles' }}" class="btn btn-sm btn-danger" type="button"> Cancel</a>
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
      input[type="checkbox"][readonly] {
        pointer-events: none;
      }
    </style>
@endsection


