
@extends('drugstore.app')

@section('title', '商品管理')

@section('CSS')
<link rel="stylesheet" href={{asset('./css/admin.css')}}>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('header')
@if (Auth::user()->permission_id == 1)
@include('drugstore.header.adminHeader')
@else
@include('drugstore.header.producerHeader')
@endif
@endsection
@php
// dd($products);
@endphp

@section('main-content')
<div class="app-container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-wrap">
        <h2>商品管理</h2>
        <table>
            <tr>
                <th>No</th>
                <th>名前</th>
                <th>カテゴリー</th>
                @if (Auth::user()->permission_id == 1)
                <th>サプライヤー</th>
                @endif
                <th>価格</th>
                <th>星</th>
                <th>作成時間</th>
                <th></th>
            </tr>
            @foreach ($products as $product)
            <tr>
                @if (Auth::user()->permission_id == 1)
                <td>{{$product->id}}</td>
                @else
                <td>{{$loop->iteration}}</td>
                @endif
                <td>{{$product->name}}</td>
                <td>{{$product->category->name}}</td>
                @if (Auth::user()->permission_id == 1)
                <td>{{$product->producer->nickname}}</td>
                @endif
                <td>{{$product->price}}</td>
                <td>{{$product->star}}</td>
                <td>{{$product->created_at}}</td>
                <!-- <td>< ?=$player['del_flg'] ?></td> -->
                <td class="view">
                    @if (Auth::user()->permission_id == 1)
                    <a href="{{route('product.show', ['product' => $product->id,'page'=>'admin'])}}">詳細</a>
                    @else
                    <a href="{{route('producer.productShow', ['id' => $product->id])}}">詳細</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
        <div class="paging">
            {{ $products->links() }}
        </div>

        <div class="creat-new">
            @if (Auth::user()->permission_id == 1)
            <a href="{{route('product.create')}}">新規作成</a>
            @else
            <a href="{{route('producer.productCreate')}}">新規作成</a>
            @endif
        </div>

    </div>

</div>
@endsection