@extends('drugstore.app')

@section('title', 'ユーザー編集')

@section('CSS')
<link rel="stylesheet" href={{asset('./css/admin.css')}}>
@endsection

@section('header')
@include('drugstore.header.adminHeader')
@endsection

@section('main-content')
<div class="app-container">
    <div class="user__table-wrap">
        <h2>ユーザー編集</h2>
        <form action="{{route('user.update',['user' => $user->id])}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="avatar">
                @if ($user->avatar !== null)
                <img class="avatar-img" src="{{ asset('img/user_img/' . $user->avatar) }}" alt="avatar">
                @else
                <i class="user-icon fa-solid fa-circle-user"></i>
                @endif
                <input type="file" id="file" name="avatar" class="avatar-upfile">
            </div>
            <div class="info">
                <ul class="info-list">
                    <li class="info-list__item">
                        <div class="infor-list__key">役割:</div>
                        <div class="infor-list__value">
                            <select name="permission" id="deli_status">
                                @if (old('permission'))
                                <option value="2" {{old('permission')==2?'selected':''}}>producer</option>
                                <option value="3" {{old('permission')==3?'selected':''}}>user</option>
                                @else
                                <option value="2" {{$user->permission_id ==2?'selected':''}}>producer</option>
                                <option value="3" {{$user->permission_id ==3?'selected':''}}>user</option>
                                @endif
                            </select>
                        </div>
                    </li>
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
                            <input name="nickname" type="text" value={{$user->nickname}}>
                            @if($errors->has('nickname'))
                            <span class="form-message error">{{ $errors->first('nickname') }}</span>
                            @endif
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">メールアドレス:</div>
                        <div class="infor-list__value">
                            <input name="email" type="text" value={{$user->email}}>
                            @if($errors->has('email'))
                            <span class="form-message error">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">電話番号:</div>
                        <div class="infor-list__value">
                            <input name="phone" type="text" value={{$user->phone}}>
                            @if($errors->has('phone'))
                            <span class="form-message error">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                    </li>
                    <li class="info-list__item">
                        <div class="infor-list__key">住所:</div>
                        <div class="infor-list__value">
                            <input name="address" type="text" value={{$user->address}}>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="action">
                <div class="edit">
                    <a href="{{route('user.show', ['user' => $user->id])}}">戻る</a>
                </div>
                <div class="delete">
                    <button type="submit">確認</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection