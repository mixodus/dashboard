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
                      <i class="fa fa-align-justify"></i>Show Admin
                </div>
                <div class="card-body">
                <div class="row">
                    <div class="col-12">
                      <label><b>Name :</b></label>
                      <input class="form-control" name="confrim_password" type="text" value = "{{ $data[0]->first_name }}" readonly>
                      <br>
                      <label><b>Company :</b></label>
                      <input class="form-control" name="confrim_password" type="text" value = "{{ $data[0]->company_name }}" readonly>
                      <br>
                      <label><b>Role Permission :</b></label>
                      <input class="form-control" name="confrim_password" type="text" value = "{{ $data[0]->user_role }}" readonly>
                      <br>
                      <label><b>Email :</b></label>
                      <input class="form-control" name="confrim_password" type="text" value = "{{ $data[0]->email }}" readonly>
                      <br>
                      <label><b>Status :</b></label>
                      <input class="form-control" name="confrim_password" type="text" value = "{{ ($data[0]->first_name == 1) ? 'Active' : 'Not Active' }}" readonly>
                      <br>
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