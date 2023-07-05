@extends('drugstore.app')

@section('title', '注文履歴')

@section('CSS')
<link rel="stylesheet" href={{asset('./css/admin.css')}}>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('header')
@include('drugstore.header.userHeader')
@endsection

@section('main-content')
<div class="app-container">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @php
    $starList = [];
    foreach ($stars as $star) {
    $starList[$star->product_id] = $star->star_number;
    }
    // dd($order_fails);
    @endphp

    <div class="table-wrap">
        <div class="user__table-wrap" style="margin: 40px 5%">
            <h2>注文履歴</h2>
            <div class="back">
                <a href="{{route('homepage')}}"><i class="fa-solid fa-arrow-left"></i></a>
            </div>
            <div>
                <ul class="myOrder-list">
                    @foreach ($orderList as $order)
                    <li class="myOrder-item">
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
                        <div class="myOrder-item__down">
                            @php
                                foreach($order_fails as $orderFail) {
                                    // dd($orderFail->cancel_from_id);
                                    if ($order->id == $orderFail->order_id && $orderFail->cancel_from_id == Auth::user()->id) {
                                        $text = "キャンセルしました。";
                                    } elseif ($order->id == $orderFail->order_id && $orderFail->cancel_from_id != Auth::user()->id) {
                                        $text = "キャンセルされました。";
                                    }
                                }
                            @endphp

                            <div class="item__down-info">
                                <div class="item__down-status"> {{--$order->id--}}
                                    {{-- @if ($order->del_flg == 1)
                                    <p>{{$text}}</p>
                                    @else --}}
                                    <p>{{$order->deli_status}}です。</p>
                                    {{-- @endif --}}
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
                                        <div class="down-product__btn">
                                            <div class="down-product__buy-again">
                                                <div class="product-quantity__number hidden"><input type="hidden"
                                                        value="1"></div>
                                                <a onclick="addCart(event,{{$order->product->id}})" href="">再度購入</a>
                                            </div>
                                            @if (($order->del_flg != 1) && $order->deli_status !== '配達完了' )
                                            <div class="down-product__cancel">
                                                <a href="{{route('user.order.cancel',['id' => $order->id])}}">キャンセル</a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($order->del_flg != 1)
                            <div class="down-product__action">
                                <div class="down-product__edit">
                                    {{-- show cho user nếu chưa ship và cho admin --}}
                                    @if ($order->deli_status !== '配達完了')
                                    <a href="{{route('order.userEdit',['id' => $order->id])}}">編集</a>
                                    @endif
                                </div>
                                <div class="down-product__review">
                                    <p>商品レビューを書く</p>

                                    @if (isset($starList["$order->product_id"]) && $starList["$order->product_id"] !=
                                    [])
                                    <div class="down-product__star" style="display: none;">
                                        <span>
                                            @for ($i = 1; $i <= $starList[$order->product_id]; $i++)
                                                <i class="product-item__star--gold fa-solid fa-star"
                                                    star_value="{{$i}}"></i>
                                                @endfor
                                                @for ($i = $starList[$order->product_id]+1; $i <= 5; $i++) <i
                                                    class="fa-solid fa-star" star_value="{{$i}}"></i>
                                                    @endfor
                                        </span>
                                        <input class="down-product__star-input" type="hidden" value="">
                                        <input class="down-product__id-input" type="hidden"
                                            value="{{$order->product_id}}">
                                        <span class="down-product__star-btn">送信</span>
                                    </div>
                                    @else
                                    <div class="down-product__star" style="display: none;">
                                        <span>
                                            <i class=" fa-solid fa-star" star_value="1"></i>
                                            <i class=" fa-solid fa-star" star_value="2"></i>
                                            <i class=" fa-solid fa-star" star_value="3"></i>
                                            <i class=" fa-solid fa-star" star_value="4"></i>
                                            <i class=" fa-solid fa-star" star_value="5"></i>
                                        </span>
                                        <input class="down-product__star-input" type="hidden" value="">
                                        <input class="down-product__id-input" type="hidden"
                                            value="{{$order->product_id}}">
                                        <span class="down-product__star-btn">送信</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="paging">
                {{ $orderList->links() }}
            </div>
        </div>
    </div>
</div>
@endsection