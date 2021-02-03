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
                      <i class="fa fa-align-justify"></i>Edit Admin
                </div>
                <div class="card-body">
                <div class="row">
                    <div class="col-12">
                    <form method="POST" action="{{ env('APP_URL', '').'/dashboard/user-management/admin/update/'.$data[0]->user_id }}">
                        @csrf
                        @method('PUT')
                      <label><b>Name :</b></label>
                                            <input 
                                                class="form-control" 
                                                name="first_name" 
                                                type="text" 
                                                placeholder="Name Admin"
                                                value="{{$data[0]->first_name}}"
                                                required
                                            >
                      <br>
                      <div class="form-group">
                        <label for="exampleFormControlSelect1"><b>Company :</b></label>
                        <select class="form-control" name="company_name" required>
                          <option name="company_name" value="ID Star" {{ ( $data[0]->company_name == 'ID Star' ) ? 'selected' : '' }}>ID Star</option>
                          <option name="company_name" value="Drife" {{ ( $data[0]->company_name == 'Drife' ) ? 'selected' : '' }}>Drife</option>
                          <option name="company_name" value="ONE Indonesia" {{ ( $data[0]->company_name == 'One Indonesia' ) ? 'selected' : '' }}>ONE Indonesia</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label><b>Role Permission :</b></label>
                        <select class="form-control" id="exampleFormControlSelect1" name="role_id" required>
                            @foreach($data_role->data as $result)
                              <option name="role_id" value="{{ $result->role_id }}" {{ ( $result->role_id == $data[0]->role_id) ? 'selected' : '' }}>{{$result->role_name}}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label><b>Status :</b></label>
                        <select class="form-control" id="exampleFormControlSelect1" name="is_active" required>
                          <option name="is_active" value="1" {{ ( $data[0]->is_active == 1 ) ? 'selected' : '' }}>Active</option>
                          <option name="is_active" value="0"  {{ ( $data[0]->is_active == 0) ? 'selected' : '' }}>Not Active</option>
                        </select>
                      </div>
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