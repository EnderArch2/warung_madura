@extends('layout.auth')
@section('auth')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-5 col-md-8">
      <div class="card shadow-lg border-0 mb-0">
        <div class="card-body px-md-5 py-5">
          <div class="text-center mb-5">
            <h4 class="font-weight-bolder mb-0">Welcome Back</h4>
            <p class="text-muted text-sm mb-0">Warung Madura Management System</p>
          </div>

          @if ($errors->any())
            <div class="alert alert-danger" role="alert">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form role="form" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
              <label class="form-label">Email Address</label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
              @error('email')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="Enter your password" required>
              @error('password')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>

            <div class="form-check form-switch mb-3">
              <input class="form-check-input" type="checkbox" name="remember" id="remember">
              <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <div class="text-center">
              <button type="submit" class="btn bg-gradient-info w-100 mt-2 mb-0">Sign In</button>
            </div>
          </form>

          <p class="text-center text-muted text-sm mt-3">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-primary font-weight-bold">Create one</a>
          </p>

          @if (Route::has('password.request'))
            <p class="text-center text-muted text-sm">
              <a href="{{ route('password.request') }}" class="text-secondary font-weight-bold">Forgot your password?</a>
            </p>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
