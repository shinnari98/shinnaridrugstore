@extends('drugstore.app')

@section('title', '問い合わせ')

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
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <h2>お問い合わせ</h2>

    <form action="{{ route('contact.confirm') }}" method="post" id="form-login">
        @csrf
        @method('POST')
        <h3>下記の項目をご記入の上送信ボタンを押してください</h3>
        <p>送信頂いた件につきましては、当社より折り返しご連絡を差し上げます。</p>
        <p>なお、ご連絡までに、お時間を頂く場合もございますので予めご了承ください。</p>
        <p><span class="red">*</span>は必須項目となります。</p>
        <div class="form-group">
            <label class="form-label" for="name">氏名<span class="red">*</span></label>
            @if($errors->has('name'))
            <span class="form-message error">{{ $errors->first('name') }}</span>
            @endif
            <input class="form-input" type="text" placeholder="山田太郎" name="name" id="name" value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label class="form-label" for="phone">電話番号</label>
            @if($errors->has('phone'))
            <span class="form-message error">{{ ($errors->first('phone')) }}</span>
            @endif
            <input class="form-input" type="text" placeholder="09012345678" name="phone" id="phone"
                value="{{ old('phone') }}">
        </div>
        <div class="form-group">
            <label class="form-label" for="email">メールアドレス<span class="red">*</span></label>
            @if($errors->has('email'))
            <span class="form-message error">{{ $errors->first('email') }}</span>
            @endif
            <input class="form-input" type="text" placeholder="test@test.co.jp" name="email" id="email"
                value="{{ old('email') }}">
        </div>

        <h3>お問い合わせ内容をご記入ください<span class="red">*</span></h3>
        @if($errors->has('content'))
        <span class="form-message error">{{ $errors->first('content') }}</span>
        @endif
        <textarea name="content" id="content" class="content">{{ old('content') }}</textarea>
        <button class="submit" type="submit" id="submit" value="submit" name="submit">送信</button>

    </form>
</div>
@endsection

