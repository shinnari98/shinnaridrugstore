@extends('drugstore.app')

@section('title', '登録完了')

@section('CSS')
<style>
    header {
        position: fixed;
        width: 100%;
    }
</style>
@endsection


@section('header')
@include('drugstore.header.header')
@endsection

@section('main-content')
<div class="overlay">
    <div class="content-main">
        <h2>
            SUCCESS
            <i class="fa-solid fa-circle-check"></i>
        </h2>
        <div class="text-nofi">
            <p>アカウント作成が完了しました。</p>
        </div>
        <div class="go-btn">
            <div class="top-back">
                <a href="{{url('index')}}">トップへ戻る</a>
            </div>
            <div class="login-back">
                <a href="{{url('login')}}">ログインへ進む</a>
            </div>
        </div>

    </div>
</div>


@endsection

@section('JS_SCRIPTS')
<script src="{{asset('js/change.js')}}"></script>
@endsection