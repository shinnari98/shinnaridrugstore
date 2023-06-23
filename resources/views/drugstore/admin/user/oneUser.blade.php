
@extends('drugstore.app')

@section('title', 'ユーザー詳細')

@section('CSS')
<link rel="stylesheet" href={{asset('./css/admin.css')}}>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('header')
@include('drugstore.header.adminHeader')
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
        <h2>ユーザー詳細</h2>
        <div class="back">
            <a href="{{route('user.index')}}"><i class="fa-solid fa-arrow-left"></i></a>
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
                    <div class="infor-list__key">ID:</div>
                    <div class="infor-list__value">{{$user->id}}</div>
                </li>
                <li class="info-list__item">
                    <div class="infor-list__key">役割:</div>
                    <div class="infor-list__value">{{$user->permission->permission_name}}</div>
                </li>
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
                    <div class="infor-list__key">作成時間:</div>
                    <div class="infor-list__value">{{$user->created_at}}</div>
                </li>
                <li class="info-list__item">
                    <div class="infor-list__key">アップデート:</div>
                    <div class="infor-list__value">{{$user->updated_at}}</div>
                </li>
            </ul>
        </div>
        <div class="action">
            <div class="delete">
                <form action="{{route('user.destroy',['user' => $user->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('No {{$user->id}} を削除しますか？')">削除</button>
                    <input type="hidden" name="delete" value="{{$user->id}}">
                </form>
            </div>
            <div class="edit"><a href="{{route('user.edit', ['user' => $user->id])}}">編集</a></div>
        </div>

    </div>

</div>
@endsection