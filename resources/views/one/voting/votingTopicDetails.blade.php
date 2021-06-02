@extends('one.layout.base')

@section('content')
        <div class="container-fluid">
            <div class="fade-in">
            <div class="card">
                <div class="card-header">
                      <i class="fa fa-align-justify"></i>Details <div class="float-right"><a href="{{ env('APP_URL', '').'/dashboard/voting' }}" class="btn btn-sm btn-danger" type="button">Back</a></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label><b> </b></label>
                        </div>
                        <div class="col-md-4"><img src="{{$details->banner_url}}" alt="Banner Icon" class="img-fluid"></div>
                        <div class="col-md-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label><b>Topic </b></label>
                        </div>
                        <div class="col-md-10">{{$details->name}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label><b>Title </b></label>
                        </div>
                        <div class="col-md-10">{{$details->title}}</div>
                    </div>
                </div>
                </div>
                <!--==========================================-->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>Candidates <br> <br>
                        @if($action!=null)
                        @if(in_array("add", $action))
                        <a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/topic/create/candidate/'.$details->topic_id}}"><i class="cil-plus"></i>Create Candidates</a>
                        @endif
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
                                        <th>Candidate's Icon</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($details->choices != null)
                                        @foreach($details->choices as $index => $choice)
                                            <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $choice->name }}</td>
                                            <td><a href="{{$choice->icon_url}}">Icon</a></td>
                                            <td>
                                            @if($action!=null)
                                            @if(in_array("edit", $action))
                                                <a class="btn btn-sm btn-primary" href="{{ env('APP_URL', '').'/dashboard/topic/update/candidate/'.$details->topic_id.'/'.$choice->choice_id}}"><i class="cil-plus"></i>Update</a>
                                            @endif
                                            @endif
                                            @if($action!=null)
                                            @if(in_array("delete", $action))
                                                <button class="btn btn-sm btn-danger" onclick="deleteConfirmation('{{ env('APP_URL', '').'/dashboard/topic/delete/candidate/'.$choice->choice_id}}')">Delete</button>
                                            @endif
                                            @endif
                                            </td>
                                            </tr>
                                        @endforeach
                                    @else
                                            <tr>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            </tr>
                                    @endif
                                    </tbody>
                    </table>
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

