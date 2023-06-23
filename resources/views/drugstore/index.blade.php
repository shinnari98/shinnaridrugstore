@extends('drugstore.app')

@section('title', 'ホームページ')

@section('CSS')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('header')
@include('drugstore.header.header')
@endsection

@section('main-content')
<div class="app-container">
 
    @include('drugstore.item.slider')

    @include('drugstore.product.recommend', ['recommends' => $recommends])

    @include('drugstore.product.product', ['products' => $products])

</div>

@endsection


@section('JS')
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>  --}}
@endsection