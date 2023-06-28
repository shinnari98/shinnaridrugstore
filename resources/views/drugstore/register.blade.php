@extends('drugstore.app')

@section('title', '登録')

@section('CSS')
<style>
    .box-title__register {
        color: #d70466;
        font-size: 28px;
    }

    .box-title__login a {
        color: #666;
        font-size: 18px;
        text-decoration: none;
    }
</style>
@endsection

@section('header')
@include('drugstore.header.header')
@endsection

@section('main-content')
<div class="overlay">
    <div class="login-box" id="login-box">
        <div class="box-title">
            <p class="box-title__login"><a href="{{ url('login') }}">ログイン</a></p>
            <p class="box-title__register">登録</p>
        </div>

        <form action="{{ route('register') }}" method="POST" name="registerForm" class="registerForm">
            @csrf
            <div class="register__form">
                <div class="form-group">
                    <label class="form-label" for="name">氏名<span class="red">*</span></label>
                    @if($errors->has('name'))
                    <span class="form-message error">{{ $errors->first('name') }}</span>
                    @endif
                    <input type="text" class="form-input" name="name" placeholder="山本" value="{{ old('name') }}">
                </div>      
                <div class="form-group">
                    <label class="form-label" for="nickname">ニックネーム<span class="red">*</span></label>
                    @if($errors->has('nickname'))
                    <span class="form-message error">{{ $errors->first('nickname') }}</span>
                    @endif
                    <input type="text" class="form-input" name="nickname" placeholder="yama123"
                        value="{{ old('nickname') }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="name">メールアドレス<span class="red">*</span></label>
                    @if($errors->has('email'))
                    <span class="form-message error">{{ $errors->first('email') }}</span>
                    @endif
                    <input type="text" class="form-input" name="email" placeholder="test@test.co.jp" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="name">パスワード<span class="red">*</span></label>
                    @if($errors->has('password'))
                    <span class="form-message error">{{ $errors->first('password') }}</span>
                    @endif
                    <input type="password" class="form-input" name="password" placeholder="123456" value="">
                </div>
                <div class="form-group">
                    <label class="form-label" for="name">パスワード確定<span class="red">*</span></label>
                    @if($errors->has('password_confir'))
                    <span class="form-message error">{{ $errors->first('password_confir') }}</span>
                    @endif
                    <input type="password" class="form-input" name="password_confir" placeholder="123456" value="">
                </div>
                <button class="submit" type="submit" id="register-submit" value="register-submit"
                    name="register-submit">送信</button>

            </div>
        </form>
    </div>
</div>
@endsection