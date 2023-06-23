@extends('drugstore.app')

@section('title', '管理者ホームページ')

@section('CSS')
<link rel="stylesheet" href={{asset('./css/admin.css')}}>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('header')
@include('drugstore.header.adminHeader')
@endsection
@php
// dd(session()->get('likes'));
// dd($likes);
@endphp

@section('main-content')
<div class="app-container">
    @include('drugstore.item.slider')

    @include('drugstore.product.recommend')

    @include('drugstore.product.product')

</div>
@endsection