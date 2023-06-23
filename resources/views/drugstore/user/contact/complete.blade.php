@extends('drugstore.app')

@section('title', '問い合わせ完了')

{{-- <h1>{{$test}}  test</h1> --}}
@section('header')
@if (!Auth::user())
@include('drugstore.header.header')
@elseif (Auth::user()->permission_id == 3)
@include('drugstore.header.userHeader')
@else
@include('drugstore.header.producerHeader')
@endif
@endsection

@section('main-content')
<div class="form-main">
    <h2>お問い合わせ</h2>
    <div class="text-nofi">
        <p>お問い合わせありがとうございました。</p>
        <p>送信頂いた件につきましては、当社より折り返しご連絡を差し上げます。</p>
        <p>なお、ご連絡までにお時間を頂く場合もございますので予めご了承ください。</p>
        <div class="top-back">
            <a href="{{url('/homepage')}}">トップへ戻る</a>
        </div>
        
    </div>
</div>

@endsection