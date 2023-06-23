@extends('drugstore.app')

@section('title', '注文完了')

{{-- <h1>{{$test}}  test</h1> --}}
@section('header')
@include('drugstore.header.userHeader', ['user' => $user])
@endsection

@section('main-content')
<div class="form-main">
    <h2>お問い合わせ</h2>
    <div class="text-nofi">
        <p>注文が完了しました！</p>
        <p>ご注文内容と配送先情報をご確認ください。</p>
        <p>なお、お問い合わせや配送に関するご質問がありましたら、お気軽にご連絡ください。</p>
        <p>ご注文ありがとうございました。</p>
        <div class="top-back">
            <a href="{{url('/homepage')}}">トップへ戻る</a>
        </div>
        
    </div>
</div>

@endsection