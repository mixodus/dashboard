@extends('one.authBase')

@section('content')

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <h1>Login</h1>
                <p class="text-muted">Sign In to your account</p>
                <form method="POST" action="{{ route('post.login') }}">
                   @csrf <!-- {{ csrf_field() }} -->
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="icon-user"></i>
                        </span>
                    </div>
                    <input class="form-control" type="text" placeholder="{{ __('Email') }}" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="icon-lock"></i>
                        </span>
                    </div>
                    <input class="form-control" type="password" placeholder="{{ __('Password') }}" name="password" required>
                    @if ($errors->has('password'))
                      <div class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                      </div>
                    @endif
                    </div>
                    <div class="row">
                      <div class="col-6">
                          <button class="btn btn-primary px-4" type="submit">{{ __('Login') }}</button>
                      </div>
                    </form>
                    <div class="col-6 text-right">
                    </div>
                    </div>
              </div>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
              <div class="card-body text-center">
                <div>
                  <h3>ONE Talent App</h3>
                  <p>Build Your Virtual CV, Find suitable Job, Improve your skill!</p>
                  <img src="assets/image/one-app.png" style="width: 50%;">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('javascript')

@endsection