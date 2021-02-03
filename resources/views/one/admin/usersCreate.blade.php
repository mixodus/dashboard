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
                      <i class="fa fa-align-justify"></i>Create Admin
                </div>
                <div class="card-body">
                <div class="row">
                    <div class="col-12">
                    <form method="POST" action="{{ env('APP_URL', '').'/dashboard/user-management/admin/store' }}">
                        @csrf
                        @method('POST')
                      <label><b>Name :</b></label>
                                            <input 
                                                class="form-control" 
                                                name="first_name" 
                                                type="text" 
                                                placeholder="Name Admin"
                                                required
                                            >
                      <br>
                      <div class="form-group">
                        <label for="exampleFormControlSelect1"><b>Company :</b></label>
                        <select class="form-control" name="company_name" required>
                          <option name="company_name" value="-">Select Company</option>
                          <option name="company_name" value="ID Star">ID Star</option>
                          <option name="company_name" value="Drife">Drife</option>
                          <option name="company_name" value="ONE Indonesia">ONE Indonesia</option>
                        </select>
                      </div>
                      <br>
                      <div class="form-group">
                        <label><b>Role Permission :</b></label>
                        
                        <select class="form-control" id="exampleFormControlSelect1" name="role_id" required>
                          <option name="role_id" value="-">Select Role</option>
                          @foreach($data->data as $result)
                            <option name="role_id" value="{{$result->role_id}}">{{$result->role_name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <br>
                      <label><b>Email :</b></label>
                      <input class="form-control" name="email" type="text" placeholder="Email" required>
                      <br>
                      <br>
                      <label><b>Password :</b></label>
                      <input class="form-control" name="password" type="password" placeholder="Password" required>
                      <br>
                      <label><b>Confrime Password :</b></label>
                      <input class="form-control" name="confrim_password" type="password" placeholder="Confrim Password" required>
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