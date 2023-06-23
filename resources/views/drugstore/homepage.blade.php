
@extends('drugstore.app')

@section('title', 'ホームページ')

@section('CSS')
@if (Auth::user()->permission_id != 3 )
<link rel="stylesheet" href={{asset('./css/admin.css')}}>
@endif
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('header')
@if (Auth::user()->permission_id == 2)
@include('drugstore.header.producerHeader')
@else
@include('drugstore.header.userHeader')
@endif
@endsection

@section('main-content')
<div class="app-container">
    @include('drugstore.item.slider')

    @include('drugstore.product.recommend')

    @include('drugstore.product.product')

</div>
@endsection