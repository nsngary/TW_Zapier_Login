@extends('layouts.main')

@section('content')
<div class="Nixon-login">
  <div class="container">
    <div class="login-content">
      <div class="login-logo">
        <h2>
          <img src="{{ asset('logo/logoSmall.png') }}" style="width:50px;height:43px;"/>
          後端管理系統
        </h2>
      </div>
      <div class="login-form">
        <h4>帳號登錄</h4>
        <form method="POST" action="{{ route('login.post') }}">
          @csrf
          <div class="form-group">
            <label>帳號</label>
            <input type="text" name="account" value="{{ old('account') }}" class="form-control" placeholder="帳號">
          </div>
          <div class="form-group">
            <label>密碼</label>
            <input type="password" name="password" class="form-control" placeholder="密碼">
          </div>
          <button type="submit" class="btn btn-primary btn-flat">登入</button>

          @error('account')
            <p class="text-danger mt-2">{{ $message }}</p>
          @enderror
        </form>
      </div>
    </div>
  </div>
</div>
@endsection