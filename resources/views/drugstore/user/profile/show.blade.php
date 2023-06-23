@extends('drugstore.app')

@section('title', 'ユーザー詳細')

@section('CSS')
<link rel="stylesheet" href={{asset('./css/admin.css')}}>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('header')
@if (Auth::user()->permission_id == 2)
@include('drugstore.header.producerHeader')
@else
@include('drugstore.header.userHeader')
@endif
@endsection
@php
// dd($user);
@endphp

@section('main-content')
<div class="app-container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="user__table-wrap">
        <h2>プロフィール</h2>
        <div class="back">
            <a href="{{route('homepage')}}"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <div class="avatar">
            @if ($user->avatar !== null)
            <img class="avatar-img" src="{{ asset('img/user_img/' . $user->avatar) }}" alt="avatar">
            @else
            <i class="user-icon fa-solid fa-circle-user"></i>
            @endif
        </div>
        <div class="info">
            <ul class="info-list">
                <li class="info-list__item">
                    <div class="infor-list__key">名前:</div>
                    <div class="infor-list__value">{{$user->name}}</div>
                </li>
                <li class="info-list__item">
                    <div class="infor-list__key">ニックネーム:</div>
                    <div class="infor-list__value">{{$user->nickname}}</div>
                </li>
                <li class="info-list__item">
                    <div class="infor-list__key">メールアドレス:</div>
                    <div class="infor-list__value">{{$user->email}}</div>
                </li>
                <li class="info-list__item">
                    <div class="infor-list__key">電話番号:</div>
                    <div class="infor-list__value">{{$user->phone}}</div>
                </li>
                <li class="info-list__item">
                    <div class="infor-list__key">住所:</div>
                    <div class="infor-list__value">{{$user->address}}</div>
                </li>
                <li class="info-list__item">
                    <div class="infor-list__key">パスワード:</div>
                    <div class="infor-list__value">
                        <span id="passwordDisplay" class="password-display">
                            @for ($i = 0; $i < 8; $i++)
                                &bull;
                            @endfor
                        </span>
                    </div>
                </li>
            </ul>
        </div>
        <div class="action">
            @if (Auth::user()->permission_id  == 3)
            <div class="edit"><a href="{{route('user.editProfile')}}">編集</a></div>
            @else
            <div class="edit"><a href="{{route('producer.editProfile')}}">編集</a></div>
            @endif
        </div>

    </div>

</div>
@endsection