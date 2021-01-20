@extends('one.layout.base')

@section('content')

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="clearfix">
            <h1 class="float-left display-3 mr-4">500</h1>
            <h4 class="pt-3">One Talent, we have a problem!</h4>
            <p class="text-muted">The page you are looking for is temporarily unavailable.</p>
            <p class="text-muted">{{$err_messages}}</p>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('javascript')

@endsection