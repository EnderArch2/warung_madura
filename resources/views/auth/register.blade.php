@extends('layout.auth')
@section('auth')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-5 col-md-8">
      <div class="card shadow-lg border-0 mb-0">
        <div class="card-body px-md-5 py-5">
          <div class="text-center mb-5">
            <h4 class="font-weight-bolder mb-0">Create Account</h4>
            <p class="text-muted text-sm mb-0">Join Warung Madura Management System</p>
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

          <form role="form" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                placeholder="Enter your full name" value="{{ old('name') }}" required autofocus>
              @error('name')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Email Address</label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="Enter your email" value="{{ old('email') }}" required>
              @error('email')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Phone Number</label>
              <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                placeholder="Enter your phone number" value="{{ old('phone_number') }}">
              @error('phone_number')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="Enter password (min 8 characters)" required>
              @error('password')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Confirm Password</label>
              <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                placeholder="Confirm password" required>
              @error('password_confirmation')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>

            <div class="text-center">
              <button type="submit" class="btn bg-gradient-success w-100 mt-2 mb-0">Create Account</button>
            </div>
          </form>

          <p class="text-center text-muted text-sm mt-3">
            Already have an account?
            <a href="{{ route('login') }}" class="text-primary font-weight-bold">Sign in here</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
