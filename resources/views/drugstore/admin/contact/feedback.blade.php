{{-- @php dd($info); @endphp --}}
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
    <h2>フィードバック</h2>
    <form action="{{ route('admin.sendFeedback') }}" method="POST">
        @csrf
        @method('POST')
        <input name="user_id" type="hidden" value="{{$user->id}}">
        <input name="send_to" type="hidden" value="{{$contact['id']}}">
        <input name="name" type="hidden" value="{{$user->name}}">
        <input name="email" type="hidden" value="{{$user->email}}">
        <input name="permission_id" type="hidden" value="{{$user->permission_id}}">
        <input name="type_of" type="hidden" value="feedback">
        <div class="form-group">
            <span class="form-label">TO:</span><br />
            <span class="form-value">{{$contact['email']}}</span> 
        </div>
        <div class="form-group">
            <span class="form-label">フィードバック内容:</span><br />
            <textarea name="content" class="feedback-content">
SHINNARI drugstore 株式会社
いつもお世話になっております。
ご問い合わせありがとうございました。


--------------------------------------------
住所 東京都渋谷区渋谷99丁目6-99
電話番号 010-2345-6789
メールアドレス shinnari-drugstore@co.jp
--------------------------------------------
            </textarea>
        </div>
        <div class="feedbackForm-btn">
            {{-- <button name="previous" id="previous" class="previous" type="submit" value="backContact">戻る</button>
            --}}
            <div class="back-btn">
                <a href="{{route('contact.show',['contact' => $contact['id']])}}">戻る</a>
            </div>
            <button class="feedback-btn" type="submit">返信</button>

        </div>
    </form>
</div>

@endsection