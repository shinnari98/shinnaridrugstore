@extends('drugstore.app')

@section('title', '問い合わせ確認')

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
    <h2>送信内容はこれでよろしいですか？</h2>
    <form action="{{ route('contact.complete') }}" method="POST">
    @csrf         
        <div class="form-group">
            <span class="form-label">氏名:</span><br/>
            <span class="form-value">{{old('name',$data['name'])}}</span>
            <input name="name" type="hidden" value="{{$data['name']}}">
        </div>
        <div class="form-group">
            <span class="form-label">電話番号:</span><br/>
            <span class="form-value">{{old('phone',$data['phone'])}}</span>
            <input name="phone" type="hidden" value="{{$data['phone']}}">
        </div>
        <div class="form-group">
            <span class="form-label">メールアドレス:</span><br/>
            <span class="form-value">{{old('email',$data['email'])}}</span>
            <input name="email" type="hidden" value="{{$data['email']}}">
        </div>
        <div class="form-group">
            <span class="form-label">お問い合わせ内容:</span><br/>
            <span class="form-value" style="word-wrap: break-word;">{!! nl2br(e($data['content'])) !!}</span>
            <input name="content" type="hidden" value="{{$data['content']}}">
        </div>
        <div class="confirm-btn">
            <button name="previous" id="previous" class="previous" type="submit" value="backContact">戻る</button>
            <button name="next" id="next" class="next" type="submit">送信</button>
            
        </div>
    </form>
</div>

@endsection