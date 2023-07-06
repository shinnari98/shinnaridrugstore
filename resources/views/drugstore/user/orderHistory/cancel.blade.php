{{-- @php dd(Auth::user()->id); @endphp --}}
@extends('drugstore.app')

@section('title', '注文キャンセル')

@section('CSS')
<link rel="stylesheet" href={{asset('./css/admin.css')}}>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('header')
@if (Auth::user()->permission_id == 3)
@include('drugstore.header.userHeader')
@else
@include('drugstore.header.producerHeader')
@endif
@endsection

@section('main-content')
<div class="app-container">
    <div class="table-wrap">
        <div class="user__table-wrap" style="margin: 40px 5%">
            <h2>注文キャンセル</h2>
            <div>
                @if (Auth::user()->permission_id == 3)
                <form action="{{route('user.orderFail')}}" method="POST" class="myOrder-list">
                @else
                <form action="{{route('producer.orderFail')}}" method="POST" class="myOrder-list">
                @endif
                    @csrf
                    @method('POST')
                    <div class="myOrder-item">
                        <div class="myOrder-item__up">
                            <div class="item__up-order">
                                <div class="item__up-date">
                                    <div class="item__up-title">注文日</div>
                                    <div class="item__up-content">{{$order->created_at}}</div>
                                </div>
                                <div class="item__up-pay">
                                    <div class="item__up-title">合計</div>
                                    <div class="item__up-content">{{$order->total_money}}</div>
                                </div>
                            </div>
                            <div class="item__up-address">
                                <div class="item__up-title">お届け先</div>
                                <div class="item__up-content">{{$order->to_address}}</div>
                            </div>
                        </div>
                        <div class="myOrder-item__down" style="display: block;">
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
                            <div class="down-product__reason">
                                <h3 class="product__reason-title">キャンセル理由</h3>
                                <textarea name="cancel_reason"></textarea>
                                <input type="hidden" name="order_id" value="{{$order->id}}">
                                <input type="hidden" name="cancel_from_id" value="{{Auth::user()->id}}">
                                <div class="down-product__btn">
                                    <div class="down-product__buy-again">
                                        <div class="product-quantity__number hidden"><input type="hidden" value="1">
                                        </div>
                                        @if (Auth::user()->permission_id == 2)
                                        <a href="{{route('producer.orderShow',['id' => $order->id])}}">戻る</a>
                                        @else 
                                        <a href="{{route('user.showOrder')}}">戻る</a>
                                        @endif
                                    </div>
                                    {{-- if　$order->deli_status　== 準備中 --}}
                                    @if ($order->deli_status !== '完了')
                                    <div class="down-product__cancel">
                                        <button type="submit">確認</button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection