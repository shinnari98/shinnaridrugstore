@php
    // dd($contacts);
@endphp
@extends('drugstore.app')

@section('title', '問い合わせ管理')

@section('CSS')
<link rel="stylesheet" href={{asset('./css/admin.css')}}>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('header')
@include('drugstore.header.adminHeader')
@endsection

@section('main-content')
<div class="app-container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-wrap">
        <table>
            <tr>
                <th>No</th>
                <th>ユーザー名</th>
                <th>名前</th>
                <th>届く時間</th>
                <th>フィードバック送る</th>
                <th>問い合わせ内容</th>
                <th></th>
            </tr>
            @foreach ($contacts as $contact)
            <tr>
                <td>{{$contact->id}}</td>
                <td>{{$contact->user != null ? $contact->user->nickname : ''}}</td>
                <td>{{$contact->name}}</td>
                <td>{{$contact->created_at}}</td>
                <td>{{$contact->have_fb}}</td>
                <td>{{$contact->content}}</td>
                <td class="view"><a href="{{route('contact.show', ['contact' => $contact->id])}}">詳細</a></td>
            </tr>
            @endforeach
        </table>
        <div class="paging">
            {{ $contacts->links() }}
        </div>
    </div>

</div>
@endsection