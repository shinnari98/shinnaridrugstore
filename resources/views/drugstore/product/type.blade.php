@php
    // dd($data);
@endphp
@extends('drugstore.app')

@section('title', '商品タイプ')

@section('CSS')
@if (Auth::user() && Auth::user()->permission_id != 3 )
<link rel="stylesheet" href={{asset('./css/admin.css')}}>
@endif
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('header')
@if (Auth::user())
    @if (Auth::user()->permission_id == 3)
        @include('drugstore.header.userHeader')
    @elseif (Auth::user()->permission_id == 1)
        @include('drugstore.header.adminHeader')
    @else
        @include('drugstore.header.producerHeader')
    @endif
@else
    @include('drugstore.header.header')
@endif
@endsection

@section('main-content')
<div class="app-container">

    @include('drugstore.product.product')

</div>
@endsection