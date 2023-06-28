@extends('drugstore.app')

@section('title', 'ログイン')

@section('header')
@include('drugstore.header.header')
@endsection

@section('main-content')
<div class="overlay">
    <div class="login-box" id="login-box">
        <div class="box-title">
            <p class="box-title__login">ログイン</p>
            <p class="box-title__register"><a href="{{ url('register') }}">登録</a></p>
        </div>
        <form action="{{ route('login') }}" method="POST" name="loginForm" class="loginForm">
            @csrf
            <div class="login__form">
                <div class="form-group">
                    <label class="form-label" for="nickname">メールアドレス<span class="red">*</span></label>
                    @if($errors->has('email'))
                    <span class="form-message error">{{ $errors->first('email') }}</span>
                    @endif
                    <input type="text" class="form-input" name="email" placeholder="test@test.co.jp" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="nickname">パスワード<span class="red">*</span></label>
                    @if($errors->has('password'))
                    <span class="form-message error">{{ $errors->first('password') }}</span>
                    @endif
                    <input type="password" class="form-input" name="password" placeholder="123456" value="">
                </div>
                <button class="submit" type="submit" id="login-submit" value="login-submit" name="login-submit">送信</button>
            </div>
        </form>
    </div>
</div>
@endsection