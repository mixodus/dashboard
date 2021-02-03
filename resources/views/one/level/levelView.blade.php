@extends('one.layout.base')

@section('content')
        <div class="container-fluid">
            <div class="fade-in">
              <div class ="row">
                <div class="col-sm-4">
                    <div class="card">
                      <!-- <div class="card-header">
                            <i class="fa fa-align-justify"></i>Employee Level
                      </div> -->
                      <div class="card-body">
                        <div class="row justify-content-center">
                          <img class="c-avatar-img2" src="{{$data->level_icon_url}}" alt="user@email.com">
                        </div>
                        </br>
                        <div class="row justify-content-center">
                          <label><h5>{{$data->fullname}}</h5></label>
                        </div>
                        <div class="row justify-content-center">
                          <label>{{$data->level->level_name}}</label>
                        </div>     
                    </div>
                  </div>
                </div>
                <div class="col-sm-8">
                    <div class="card">
                      <div class="card-header">
                            <i class="fa fa-align-justify"></i>History Level
                      </div>
                      <div class="card-body">
                      <div class="row">
                        <div class="col-md-5">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                          <i class="cil-plus"></i> Add Activity
                        </button>
                        </div>
                      </div>
                      <br>
                        <table class="table table-responsive-sm stripe" id="style_data">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Activity Point</th>
                              <th>Point</th>
                              <th>Created at</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($data->trx_points as $index=>$datas)
                              <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $datas->activity_point_code }}</td>
                                <td>{{ $datas->point }}</td>
                                <td>{{ $datas->created_at }}</td>
                              </tr>
                          @endforeach
                          </tbody>
                        </table>
                      </div>
                      <div class="card-footer">
                        <a href="{{ env('APP_URL', '').'/dashboard/user-management/employee-level' }}" class="btn btn-sm btn-danger" type="button"> Cancel</a>
                      </div>
                  </div>
                </div>
              </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Transaction Point</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form method="POST" action="{{ env('APP_URL', '').'/dashboard/user-management/employee-level/create'}}">
                @csrf
                @method('POST')
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Recipient:</label>
                    <select class="form-control" name="activity_point_id" required>
                      <option value="-">-- Select Activity --</option>
                      @foreach($activity as $activitys)
                      <option value="{{$activitys->activity_point_id}}">{{$activitys->activity_point_name}}</option>
                      @endforeach
                    </select>
                    <input name="employee_id" type="hidden" value="{{$data->user_id}}">
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
              </form>
            </div>
          </div>
        </div>
                    
@endsection


@section('javascript')
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    <style>
      .c-avatar-img2 {
        width: 50%;
        height: auto;
        border-radius: 50em;
      }
    </style>
@endsection

