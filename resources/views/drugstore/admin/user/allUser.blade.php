
@extends('drugstore.app')

@section('title', 'ユーザー管理')

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
    <div class="table-wrap">
        <h2>ユーザー管理</h2>
        <table>
            <tr>
                <th>No</th>
                <th>名前</th>
                <th>ニックネーム</th>
                <th>メールアドレス</th>
                <th>役割</th>
                <th>作成時間</th>
                <th></th>
            </tr>
            @foreach ($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->nickname}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->permission->permission_name}}</td>
                <td>{{$user->created_at}}</td>
                <!-- <td>< ?=$player['del_flg'] ?></td> -->
                <td class="view"><a href="{{route('user.show', ['user' => $user->id])}}">詳細</a></td>
                {{-- <td class="action">
                    <div class="edit"><a href="edit.php?id=< ?= $player['id'] ?>">編集</a></div>
                    <div class="delete">
                        <form action="{{route('user.destroy')}}" method="POST">
                            <button type="submit"
                                onclick="return confirm('No < ?= $player['id'] ?> を削除しますか？')">削除</button>
                            <input type="hidden" name="delete" value="< ?= $player['id']; ?>">
                        </form>
                    </div>
                </td> --}}

            </tr>
            @endforeach
        </table>

        <div class="creat-new"><a href="{{route('user.create')}}">新規作成</a></div>

    </div>

</div>
@endsection

