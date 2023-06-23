@extends('drugstore.app')
@php 
if ($errors->any()) {
    // dd($errors); 
}
@endphp
@section('title', 'ユーザー編集')

@section('CSS')
<link rel="stylesheet" href={{asset('./css/admin.css')}}>
@endsection

@section('header')
@if (Auth::user()->permission_id == 2)
@include('drugstore.header.producerHeader')
@else
@include('drugstore.header.userHeader')
@endif
@endsection

@section('main-content')
<div class="app-container">
    <div class="user__table-wrap">
        <h2>ユーザー編集</h2>
        @if (Auth::user()->permission_id  == 3)
        <form action="{{route('user.updateProfile')}}" method="POST" enctype="multipart/form-data">
        @else
        <form action="{{route('producer.updateProfile')}}" method="POST" enctype="multipart/form-data">
        @endif
            @csrf
            @method('PUT')
            <div class="avatar">
                @if ($user->avatar !== null)
                <img class="avatar-img" src="{{ asset('img/user_img/' . $user->avatar) }}" alt="avatar">
                @else
                <i class="user-icon fa-solid fa-circle-user"></i>
                @endif
                <input type="file" id="file" name="avatar" class="avatar-upfile" >
            </div>
            <div class="info">
                <ul class="info-list">
                    <li class="info-list__item">
                        <div class="infor-list__key">名前:</div>
                        <div class="infor-list__value">
                            <input name="name" type="text" value={{$user->name}}>
                            @if($errors->has('name'))
                            <span class="form-message error">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">ニックネーム:</div>
                        <div class="infor-list__value">
                            @if($errors->has('nickname'))
                            <input name="nickname" type="text" value={{old('nickname')}}>
                            <span class="form-message error">{{ $errors->first('nickname') }}</span>
                            @else
                            <input name="nickname" type="text" value={{$user->nickname}}>
                            @endif
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">メールアドレス:</div>
                        <div class="infor-list__value">
                            @if($errors->has('email'))
                            <input name="email" type="text" value={{old('email')}}>
                            <span class="form-message error">{{ $errors->first('email') }}</span>
                            @else
                            <input name="email" type="text" value={{$user->email}}>
                            @endif
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">電話番号:</div>
                        <div class="infor-list__value">
                            @if($errors->has('phone'))
                            <input name="phone" type="text" value={{old('phone')}}>
                            <span class="form-message error">{{ $errors->first('phone') }}</span>
                            @else
                            <input name="phone" type="text" value={{$user->phone}}>
                            @endif
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">住所:</div>
                        <div class="infor-list__value">
                            @if (old('address') != null)
                            <input name="address" type="text" value={{old('address')}}>
                            @else
                            <input name="address" type="text" value={{$user->address}}>
                            @endif
                        </div>
                    </li>
                    <li class="info-list__item forPassItem">
                        <div class="infor-list__key forPassKey">パスワード:</div>
                        <div class="infor-list__value forPassValue">
                            <div id="changePassword" class="changePass">パスワード編集</div>

                            <div id="changePass__box" style="display: none;">
                                <div class="changePass__item">
                                    <label for="oldPassword">前パスワード:</label>
                                    <input type="password" id="oldPassword" name="oldPassword"
                                        value="{{ old('oldPassword') }}">
                                    @if($errors->has('oldPassword'))
                                    <span class="form-message error">{{ $errors->first('oldPassword') }}</span>
                                    @endif
                                </div>
                                <div class="changePass__item">
                                    <label for="newPassword">新パスワード:</label>
                                    <input type="password" id="newPassword" name="newPassword"
                                        value="{{ old('newPassword') }}">
                                    @if($errors->has('newPassword'))
                                    <span class="form-message error">{{ $errors->first('newPassword') }}</span>
                                    @endif
                                </div>
                                <div class="changePass__item">
                                    <label for="passConfirm">新パスワード確定:</label>
                                    <input type="password" id="passConfirm" name="passConfirm"
                                        value="{{ old('passConfirm') }}">
                                    @if($errors->has('passConfirm'))
                                    <span class="form-message error">{{ $errors->first('passConfirm') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="action">
                <div class="edit">
                    <a href="{{route('user.showUser')}}">戻る</a>
                </div>
                <div class="delete">
                    <button type="submit">確認</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection