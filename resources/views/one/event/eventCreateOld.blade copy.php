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
              <div class="row">
                <div class="col-md-12">
                <form method="POST" action="{{ env('APP_URL', '').'/dashboard/event/store' }}" enctype="multipart/form-data" autocomplete="off">
                  {{ csrf_field() }}
                  <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i>Event Form</div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-6">
                          <img src="" class="img-thumbnail" width="150" height="150" id="preview" />
                        </div>
                        <div class="col-sm-6">
                        </div>
                      </div>
                      </br>
                      <div class="row">
                        <div class="col-sm-6">
                          <label><b>Event Banner :</b></label>
                          <input type="file" name="event_banner" class="file" accept="image/*">
                          <div class="input-group">
                            <input type="text" class="form-control" disabled placeholder="Upload File" id="file">
                            <div class="input-group-append">
                              <button type="button" class="browse btn btn-primary">Browse...</button>
                            </div>
                          </div>
                          <small>size max upload image 5Mb.</small>
                        </div>
                        <div class="col-sm-6">
                          <label><b>Event Title :</b></label>
                          <input class="form-control" name="event_title" type="text" placeholder="Input event title" required>
                        </div>
                        
                      </div>
                      </br>
                      <div class="row">
                      <div class="col-sm-6">
                          <label><b>Event Type :</b></label>
                          <select class="form-control" name="event_type_id" required>
                              <option value="0">-- Select Event type --</option>
                              @foreach($data_type as $types)
                                <option value="{{$types->event_type_id}}">{{$types->event_type_name}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                          <label><b>Event Date :</b></label>
                          <input class="form-control" name="event_date" type="date">
                        </div>
                      </div>
                      </br>
                      <div class="row">
                      <div class="col-sm-6" style="display:none">
                          <label><b>Event Place :</b></label>
                          <input class="form-control" name="event_place" type="text" placeholder="Input palace">
                        </div>
                        <div class="col-sm-6">
                          <label><b>Event Speaker :</b></label>
                          <input class="form-control" name="event_speaker" type="text" placeholder="Input speaker">
                        </div>
                      </div>
                      </br>
                      <div class="row">
                      <div class="col-sm-6">
                          <label><b>Company :</b></label>
                          <select class="form-control" name="company_id" required>
                              <option value="0">-- Select Company --</option>
                              @foreach($company as $companys)
                                <option value="{{$companys->company_id}}">{{$companys->name}}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>
                      </br>
                      <div class="row">
                        <div class="col-sm-12">
                          <label><b>Event Description :</b></label>
                          <textarea class="form-control" name="event_note" rows="5" placeholder="Typing event description.." id="summary-ckeditor"></textarea>
                        </div>
                      </div>
                      <div class="card-footer">
                        <button class="btn btn-sm btn-primary" type="submit"> Submit</button>
                        <a href="{{ env('APP_URL', '').'/dashboard/event' }}" class="btn btn-sm btn-danger" type="button"> Cancel</a>
                      </div>
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
    <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
      CKEDITOR.replace( 'summary-ckeditor' );
    </script>
    <style>
      .file {
              visibility: hidden;
              position: absolute;
            }
    </style>
@endsection

