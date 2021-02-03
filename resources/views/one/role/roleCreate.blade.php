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
                      <i class="fa fa-align-justify"></i>Create Role
                </div>
                <div class="card-body">
                <div class="row">
                    <div class="col-12">
                    <form method="POST" action="{{ env('APP_URL', '').'/dashboard/settings/roles/store' }}">
                        @csrf
                        @method('POST')
                      <label><b>Role Name :</b></label>
                                            <input 
                                                class="form-control" 
                                                name="role_name" 
                                                type="text" 
                                                placeholder="Name Role"
                                                required
                                            >
                      <br>
                      <div class="form-group">
                        <label for="exampleFormControlSelect1"><b>Company :</b></label>
                        <select class="form-control" id="exampleFormControlSelect1" name="company" required>
                          <option name="company" value="-">Select Company</option>
                          <option name="company" value="1">ID Star</option>
                          <option name="company" value="2">Drife</option>
                          <option name="company" value="3">ONE Indonesia</option>
                        </select>
                      </div>
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
                          @foreach($data as $results)
                            <tr>
                              <td>{{ $results->name }}</td>
                              <td>{{ $results->group_name }}</td>
                              <td>
                                @foreach($results->action as $actions)
                                <div class="form-check checkbox">
                                  <input class="form-check-input" name="action[]" type="checkbox" value="{{ $actions->menu_id.'-'.$actions->action }}">
                                  {{$actions->action}}
                                </div>
                                @endforeach
                              </td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                      <div class="card-footer">
                        <button class="btn btn-sm btn-primary" type="submit"> Submit</button>
                        <a href="{{ env('APP_URL', '').'/dashboard/settings/roles' }}" class="btn btn-sm btn-danger" type="button"> Cancel</a>
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

