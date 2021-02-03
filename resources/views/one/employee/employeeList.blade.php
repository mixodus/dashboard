@extends('one.layout.base')

@section('content')
        <div class="container-fluid">
            <div class="fade-in">
              @if ($message = Session::get('success'))
              <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $message }}</strong>
              </div>
              @endif
              <div class="card">
                <div class="card-header">
                      <i class="fa fa-align-justify"></i>Admin List
                </div>
                <div class="card-body">
                @if(in_array("add", $action))
                  <div class="row">
                    <div class="col-md-5">
                      <a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/user-management/admin/create' }}"><i class="cil-plus"></i> Create Role</a>
                    </div>
                  </div>
                  <br>
                @endif
                <table class="table table-responsive-sm stripe" id="style_data">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Fullname</th>
                            <th>E-mail</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $index => $results)
                            <tr>
                              <td>{{ $index+1 }}</td>
                              <td>{{ $results->fullname }}</td>
                              <td>{{ $results->email }}</td>
                              <td>{{ $results->gender }}</td>
                              <td>{{ ($results->is_active == 1)? "Active" : "Not Active" }}</td>
                              <td>
                                @if(in_array("edit", $action))
                                <a href="{{ env('APP_URL', '').'/dashboard/user-management/employee/edit/'.$results->user_id }}" class="btn btn-block btn-dark">Edit</a>
                                @endif
                              </td>
                              <td>
                                @if(in_array("delete", $action))
                                  <button class="btn btn-block btn-danger" onclick="deleteConfirmation({{$results->user_id}})">Delete User</button>
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
    <script type="text/javascript">
      function deleteConfirmation(id) {
          swal({
              title: "Delete role",
              text: "Are you sure you want to delete data?",
              type: "warning",
              showCancelButton: !0,
              cancelButtonText: "cancel",
              confirmButtonText: "delete",
              reverseButtons: !0
          }).then(function (e) {
              if (e.value === true) {
                  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                  $.ajax({
                      type: 'GET',
                      url: "{{url('/dashboard/user-management/employee/delete')}}/"+id,
                      data: {_token: CSRF_TOKEN},
                      dataType: 'JSON',
                      success: function (results) {
                          if (results.success === true) {
                              swal("Done!", results.message, "success").then(function (e){
                                if (e.value === true){
                                    window.location.reload();
                                }
                              });
                          } else {
                              swal("Error!", results.message, "error");
                          }
                      }
                  });

              } else {
                  e.dismiss;
              }

          }, function (dismiss) {
              return false;
          })
      }

      $(document).ready(function() {
          $('#style_data').DataTable( {
            "searching": false,
            "ordering": false,
          } );
      } );
    </script>
@endsection

