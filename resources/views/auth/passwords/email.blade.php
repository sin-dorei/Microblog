@extends('layouts.default')
@section('title', '重置密码')

@section('content')
<div class="col-md-8 offset-md-2">
  <div class="card">
    <div class="card-header"><h5>{{ __('Reset Password') }}</h5></div>

    <div class="card-body">

      @if (session('status'))

      <div class="alert alert-success">
        {{ session('status') }}
      </div>

      @endif

      <form method="POST" action="{{ route('password.email') }}">

        @csrf

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
          <label for="email" class="form-control-label">{{ __('E-Mail Address') }}</label>
          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

          @error('email')

          <span class="form-text">
            <strong>{{ $message }}</strong>
          </span>

          @enderror

        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">
            {{ __('Send Password Reset Link') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
