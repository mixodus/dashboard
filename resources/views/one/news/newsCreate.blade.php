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
                <form method="POST" action="{{ env('APP_URL', '').'/dashboard/news/store' }}" enctype="multipart/form-data" autocomplete="off">
                  {{ csrf_field() }}
                  <div class="card">
                    <div class="card-header"><i class="fa fa-align-justify"></i>News & Article Form</div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-6">
                          <img src="http://localhost/new-one-dashboard/public/assets/image/no_image.png" class="img-thumbnail" width="150" height="150" id="preview" />
                        </div>
                        <div class="col-sm-6">
                        </div>
                      </div>
                      </br>
                      <div class="row">
                        <div class="col-sm-6">
                          <label><b>News Image :</b></label>
                          <input type="file" name="news_photo" class="file" accept="image/*">
                          <div class="input-group">
                            <input type="text" class="form-control" disabled placeholder="Upload File" id="file">
                            <div class="input-group-append">
                              <button type="button" class="browse btn btn-primary">Browse...</button>
                            </div>
                          </div>
                          <small>size max upload image 5Mb.</small>
                        </div>
                        <div class="col-sm-6">
                          <label><b>News Title :</b></label>
                          <input class="form-control" name="news_title" type="text" placeholder="Input News title" required>
                        </div>
                        
                      </div>
                      </br>
                      <div class="row">
                      <div class="col-sm-6">
                          <label><b>News Type :</b></label>
                          <select class="form-control" name="news_type_id" required>
                              <option value="0">-- Select News type --</option>
                              @foreach($data_type as $types)
                                <option value="{{$types->news_type_id}}">{{$types->news_type_name}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                          <label><b>News Url :</b></label>
                          <input class="form-control" name="news_url" type="text" placeholder="Input url">
                        </div>
                      </div>
                      </br>
                      <div class="row">
                        <div class="col-sm-12">
                          <label><b>News Description :</b></label>
                          <textarea class="form-control" name="news_details" rows="5" placeholder="Typing news description.." id="summary-ckeditor"></textarea>
                        </div>
                      </div>
                      <div class="card-footer">
                        <button class="btn btn-sm btn-primary" type="submit"> Submit</button>
                        <a href="{{ env('APP_URL', '').'/dashboard/news-article' }}" class="btn btn-sm btn-danger" type="button"> Cancel</a>
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

