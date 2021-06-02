@extends('one.layout.base')

@section('content')
        <div class="container-fluid">
            <div class="fade-in">
            <div class="card">
                <div class="card-header">
                      <i class="fa fa-align-justify"></i>Voting Topic<br><br>
                        @if(in_array("add", $action))
                        <a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/topic/create'}}"><i class="cil-plus"></i>Create Topic</a>
                        @endif
                </div>
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-12">
                    <table class="table table-responsive-sm stripe" id="style_data">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($topics as $index => $topic)
                                        <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $topic->name }}</td>
                                        <td>{{ $topic->title }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/topic/details/'.$topic->topic_id}}"><i class="cil-plus"></i>Details</a>
                                            @if(in_array("edit", $action))
                                            <a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/topic/update/'.$topic->topic_id}}"><i class="cil-plus"></i>Update</a>
                                            @endif
                                            @if(in_array("delete", $action))
                                            <button class="btn btn-sm btn-danger" onclick="deleteConfirmation('{{ env('APP_URL', '').'/dashboard/topic/delete/'.$topic->topic_id}}')">Delete</button>
                                            @endif
                                        </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                    </table>
                    </div>
                    </div>
                </div>
                <!--=======================================================================-->
            </div>
          </div>
                    
@endsection


@section('javascript')
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection

