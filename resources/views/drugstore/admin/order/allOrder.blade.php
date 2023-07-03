
@extends('drugstore.app')

@section('title', '注文管理')

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
        <h2>注文書</h2>
        <table>
            <tr>
                <th>No</th>
                <th>注文ユーザー</th>
                <th>商品名</th>
                <th>数量</th>
                <th>価格</th>
                <th>配達状況</th>
                @if (Auth::user()->permission_id == 1)
                <th>キャンセル</th>
                @endif
                <th></th>
            </tr>
            @foreach ($orders as $order)
            @php
                // dd($order->user->name);
            @endphp
            <tr>
                @if (Auth::user()->permission_id == 1)
                <td>{{$order->id}}</td>
                @else
                <td>{{$loop->iteration}}</td>
                @endif
                <td>{{$order->user->name}}</td>
                <td>{{$order->product->name}}</td>
                <td style="text-align: center">{{$order->quantity}}</td>
                <td>{{$order->total_money}}</td>

                @if ($order->del_flg == 1)
                <td>キャンセルでした</td>
                @else
                <td>{{$order->deli_status}}</td>
                @endif

                @if (Auth::user()->permission_id == 1)
                <td>{{$order->del_flg}}</td>
                <td class="view"><a href="{{route('order.show', ['order' => $order->id])}}">詳細</a></td>
                @else
                <td class="view"><a href="{{route('producer.orderShow', ['id' => $order->id])}}">詳細</a></td>
                @endif
            </tr>
            @endforeach
        </table>
        <div class="paging">
            {{ $orders->links() }}
        </div>

        {{-- <div class="creat-new"><a href="{{route('product.create')}}">新規作成</a></div> --}}

    </div>

</div>
@endsection