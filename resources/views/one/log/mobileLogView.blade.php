@extends('one.layout.base')

@section('content')
        <div class="container-fluid">
            <div class="fade-in">
              <div class="card">
                <div class="card-header">
                      <i class="fa fa-align-justify"></i>Mobile Log Detail
                </div>
                <div class="card-body">
                <div class="bd-example">
                <dl class="row">
                  @foreach($log as $logs)
                    <dt class="col-sm-3 container text-right">Server Type :</dt>
                    <dd class="col-sm-9">{{$logs->server_type}}</dd>

                    <dt class="col-sm-3 container text-right">Type :</dt>
                    <dd class="col-sm-9">{{$logs->type}}</dd>

                    <dt class="col-sm-3 container text-right">Module :</dt>
                    <dd class="col-sm-9">{{$logs->module}}</dd>

                    <dt class="col-sm-3 container text-right">Version :</dt>
                    <dd class="col-sm-9">{{$logs->version}}</dd>

                    <dt class="col-sm-3 container text-right">Name :</dt>
                    <dd class="col-sm-9">{{$logs->name}}</dd>

                    <dt class="col-sm-3 container text-right">Uri :</dt>
                    <dd class="col-sm-9">{{$logs->uri}}</dd>

                    <dt class="col-sm-3 container text-right">User ID :</dt>
                    <dd class="col-sm-9">{{$logs->user_id}}</dd>

                    <dt class="col-sm-3 container text-right">IP Address :</dt>
                    <dd class="col-sm-9">{{$logs->ip_address}}</dd>

                    <dt class="col-sm-3 container text-right">Method :</dt>
                    <dd class="col-sm-9">{{$logs->method}}</dd>

                    <dt class="col-sm-3 container text-right">POST Data :</dt>
                    <input type="hidden" value="{{$logs->request_body}}" id="postdata-mobile"/>
                    <dd class="col-sm-9"><pre><code id="request-mobilebody"></code></pre></dd>

                    <dt class="col-sm-3 container text-right">Response Status :</dt>
                    <dd class="col-sm-9"><span class="badge badge-success">{{$logs->status_code}}</span></dd>

                    <dt class="col-sm-3 container text-right">Response JSON :</dt>
                    <input type="hidden" value="{{$logs->response}}" id="response-mobile"/>
                    <dd class="col-sm-9"><pre><code id="log-mobiledata"></code></pre></dd>
                  @endforeach
                </div>
                <div class="card-footer">
                  <a href="{{ env('APP_URL', '').'/dashboard/log/mobile-log' }}" class="btn btn-sm btn-danger" type="button"> Cancel</a>
                </div>
              </div>
            </div>
          </div>
                    
@endsection


@section('javascript')
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script>
      if (!library)
      var library = {};

      library.json = {
        replacer: function(match, pIndent, pKey, pVal, pEnd) {
            var key = '<span class=json-key>';
            var val = '<span class=json-value>';
            var str = '<span class=json-string>';
            var r = pIndent || '';
            if (pKey)
              r = r + key + pKey.replace(/[": ]/g, '') + '</span>: ';
            if (pVal)
              r = r + (pVal[0] == '"' ? str : val) + pVal + '</span>';
            return r + (pEnd || '');
            },
        prettyPrint: function(obj) {
            var jsonLine = /^( *)("[\w]+": )?("[^"]*"|[\w.+-]*)?([,[{])?$/mg;
            return JSON.stringify(obj, null, 3)
              .replace(/&/g, '&amp;').replace(/\\"/g, '&quot;')
              .replace(/</g, '&lt;').replace(/>/g, '&gt;')
              .replace(jsonLine, library.json.replacer);
            }
        };

      var mobilePost = $('#postdata-mobile').val();
      var mobileData = JSON.parse(mobilePost);
      var mobileResponse = $('#response-mobile').val();
      var mobileRes = JSON.parse(mobileResponse);

      $('#request-mobilebody').html(library.json.prettyPrint(mobileData));
      $('#log-mobiledata').html(library.json.prettyPrint(mobileRes));
    </script>
    <style>
      pre {
        background-color: ghostwhite;
        border: 1px solid silver;
        padding: 5px 10px;
        margin: 2px; 
      }
    .json-key {
        color: brown;
      }
    .json-value {
        color: navy;
      }
    .json-string {
        color: olive;
      }
    </style>
@endsection

                