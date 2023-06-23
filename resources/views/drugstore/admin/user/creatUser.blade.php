@extends('drugstore.app')

@section('title', 'ユーザー詳細')

@section('CSS')
<link rel="stylesheet" href={{asset('./css/admin.css')}}>
@endsection

@section('header')
@include('drugstore.header.adminHeader')
@endsection

@section('main-content')
<div class="app-container">
    <div class="user__table-wrap">
        <h2>ユーザー新規作成</h2>
        <form action="{{route('user.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="avatar">   
                @if(old('avatar'))
                <img src="{{ asset('img/user_img/' . old('avatar')) }}" alt="Avatar">
                @else
                <i class="user-icon fa-solid fa-circle-user"></i>
                @endif
                <input type="file" id="file" name="avatar" class="avatar-upfile">
            </div>
            <div class="info">
                <ul class="info-list">
                    <li class="info-list__item">
                        <div class="infor-list__key">名前:</div>
                        <div class="infor-list__value">
                            <input name="name" type="text" value="{{ old('name') }}">
                            @if($errors->has('name'))
                            <span class="form-message error">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">ニックネーム:</div>
                        <div class="infor-list__value">
                            <input name="nickname" type="text" value="{{ old('nickname') }}">
                            @if($errors->has('nickname'))
                            <span class="form-message error">{{ $errors->first('nickname') }}</span>
                            @endif
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">メールアドレス:</div>
                        <div class="infor-list__value">
                            <input name="email" type="text" value="{{ old('email') }}">
                            @if($errors->has('email'))
                            <span class="form-message error">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">電話番号:</div>
                        <div class="infor-list__value">
                            <input name="phone" type="text" value="{{ old('phone') }}">
                            @if($errors->has('phone'))
                            <span class="form-message error">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">住所:</div>
                        <div class="infor-list__value">
                            <input name="address" type="text" value="{{ old('address') }}">
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">パスワード:</div>
                        <div class="infor-list__value">
                            <input name="password" type="password">
                            @if($errors->has('password'))
                            <span class="form-message error">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">パスワード確定:</div>
                        <div class="infor-list__value">
                            <input name="password_confir" type="password">
                            @if($errors->has('password_confir'))
                            <span class="form-message error">{{ $errors->first('password_confir') }}</span>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
            <div class="action">
                <div class="edit">
                    <a href="{{route('user.index')}}">戻る</a>
                </div>
                <div class="delete">
                    <button type="submit">確認</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection