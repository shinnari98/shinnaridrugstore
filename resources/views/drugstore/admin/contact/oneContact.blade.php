{{-- @php dd($contact); @endphp --}}
@extends('drugstore.app')

@section('title', '問い合わせ詳細')

@section('CSS')
<link rel="stylesheet" href={{asset('./css/admin.css')}}>
@endsection

@section('header')
@include('drugstore.header.adminHeader')
@endsection

@section('main-content')
<div class="form-main">
    <h2>問い合わせ詳細</h2>
    <form action="{{ route('admin.feedback') }}" method="POST">
        @csrf
        @method('POST')
        <div class="form-group">
            <span class="form-label">ID:</span><br />
            <span class="form-value">{{$contact->id}}</span>
            <input name="id" type="hidden" value="{{$contact->id}}">
        </div>
        <div class="form-group">
            <span class="form-label">氏名:</span><br />
            <span class="form-value">{{$contact->name}}</span>
            <input name="name" type="hidden" value="{{$contact->name}}">
        </div>
        <div class="form-group">
            <span class="form-label">電話番号:</span><br />
            <span class="form-value">{{$contact->phone != null ? $contact->phone : 'null'}}</span>
            <input name="phone" type="hidden" value="{{$contact->phone}}">
        </div>
        <div class="form-group">
            <span class="form-label">メールアドレス:</span><br />
            <span class="form-value">{{$contact->email}}</span>
            <input name="email" type="hidden" value="{{$contact->email}}">
        </div>
        <div class="form-group">
            <span class="form-label">お問い合わせ内容:</span><br />
            <span class="form-value" style="word-wrap: break-word;">{!! nl2br(e($contact->content)) !!}</span>
            <input name="content" type="hidden" value="{{$contact->content}}">
        </div>
        <div class="feedbackForm-btn">
            {{-- <button name="previous" id="previous" class="previous" type="submit" value="backContact">戻る</button> --}}
            <div class="back-btn">
                <a  href="{{route('contact.index')}}">戻る</a>
            </div>
            <button class="feedback-btn" type="submit">フィードバック</button>

        </div>
    </form>
</div>

@endsection