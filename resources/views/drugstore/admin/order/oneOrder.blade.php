@extends('drugstore.app')

@section('title', '注文履歴')

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
// dd($user);
@endphp

@section('main-content')
<div class="app-container">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="table-wrap">
        <div class="user__table-wrap" style="margin: 40px 5%">
            <h2>注文履歴</h2>
            <div class="back">
                @if (Auth::user()->permission_id == 1)
                <a href="{{route('order.index')}}"><i class="fa-solid fa-arrow-left"></i></a>
                @else
                <a href="{{route('producer.order')}}"><i class="fa-solid fa-arrow-left"></i></a>
                @endif
            </div>
            <div>
                <ul class="myOrder-list">
                    <li class="myOrder-item">
                        <div class="myOrder-item__up">
                            <div class="item__up-order">
                                <div class="item__up-date">
                                    <div class="item__up-title">注文日</div>
                                    <div class="item__up-content">{{$order->created_at}}</div>
                                </div>
                                <div class="item__up-pay">
                                    <div class="item__up-title">合計</div>
                                    <div class="item__up-content">{{$order->total_money}}円</div>
                                </div>
                            </div>
                            <div class="item__up-address">
                                <div class="item__up-title">お届け先</div>
                                <div class="item__up-content">{{$order->to_address}}</div>
                            </div>
                        </div>
                        <div class="myOrder-item__down">
                            <div class="item__down-info">
                                <div class="item__down-status">
                                    <p>{{$order->deli_status}}です。</p>
                                    {{-- <p>2023/06/03に配達しました</p> --}}
                                </div>
                                <div class="item__down-product">
                                    <div class="down-product__img">
                                        <img src="{{asset('img/product_img/' . $order->product->image)}}" alt="">
                                    </div>
                                    <div class="down-product__content">
                                        <div class="down-product__name">
                                            <p>{{$order->product->name}}</p>
                                            <div class="down-product__x">x</div>
                                            <div class="down-product__quantity">{{$order->quantity}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="down-product__action">
                                <div class="down-product__edit">
                                    @if (Auth::user()->permission_id == 1)
                                    <a href="{{route('order.edit',['order' => $order->id])}}">編集</a>
                                    @else
                                    <a href="{{route('producer.orderEdit',['id' => $order->id])}}">編集</a>
                                    @endif
                                </div>
                                @if (Auth::user()->permission_id == 1)
                                <div class="down-product__delete">
                                    <form action="{{ route('order.destroy', ['order' => $order->id]) }}" method="POST" onsubmit="return confirm('No {{ $order->id }} を削除しますか？')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">削除</button>
                                    </form>
                                </div>
                                @endif
                                @if ($order->deli_status != '配達完了')
                                <div class="down-product__canCel">
                                    <a href="{{route('producer.order.cancel',['id' => $order->id])}}">キャンセル</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection