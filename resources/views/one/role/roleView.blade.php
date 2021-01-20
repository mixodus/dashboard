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
              </div>
            </div>
          </div>
                    <!-- <div class="col-sm-5">
                      <h4 class="card-title mb-0">Traffic</h4>
                      <div class="small text-muted">September 2019</div>
                    </div> -->
                    <!-- /.col-->
                    <!-- <div class="col-sm-7 d-none d-md-block">
                      <button class="btn btn-primary float-right" type="button">
                        <svg class="c-icon">
                          <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-cloud-download"></use>
                        </svg>
                      </button>
                      <div class="btn-group btn-group-toggle float-right mr-3" data-toggle="buttons">
                        <label class="btn btn-outline-secondary">
                          <input id="option1" type="radio" name="options" autocomplete="off"> Day
                        </label>
                        <label class="btn btn-outline-secondary active">
                          <input id="option2" type="radio" name="options" autocomplete="off" checked=""> Month
                        </label>
                        <label class="btn btn-outline-secondary">
                          <input id="option3" type="radio" name="options" autocomplete="off"> Year
                        </label>
                      </div>
                    </div> -->
                    <!-- /.col-->
                  <!-- </div> -->
                  <!-- /.row-->
                  <!-- <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                    <canvas class="chart" id="main-chart" height="300"></canvas>
                  </div> -->
                <!-- </div> -->
                <!-- <div class="card-footer">
                  <div class="row text-center">
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                      <div class="text-muted">Visits</div><strong>29.703 Users (40%)</strong>
                      <div class="progress progress-xs mt-2">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                      <div class="text-muted">Unique</div><strong>24.093 Users (20%)</strong>
                      <div class="progress progress-xs mt-2">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                      <div class="text-muted">Pageviews</div><strong>78.706 Views (60%)</strong>
                      <div class="progress progress-xs mt-2">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                      <div class="text-muted">New Users</div><strong>22.123 Users (80%)</strong>
                      <div class="progress progress-xs mt-2">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                      <div class="text-muted">Bounce Rate</div><strong>40.15%</strong>
                      <div class="progress progress-xs mt-2">
                        <div class="progress-bar" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->
              <!-- /.card-->
              
              <!-- /.row-->
             
        
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


