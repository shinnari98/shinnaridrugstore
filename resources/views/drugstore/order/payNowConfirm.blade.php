@extends('drugstore.app')
{{-- @php dd($data);@endphp --}}


@section('title', '会計確認')

@section('header')
@include('drugstore.header.userHeader', ['user' => $user])
@endsection
@section('main-content')
<div class="app-container">
    <div class="product-wrap">
        <h1 class="product-title">決済</h1>
        <form action="{{route('payNow.complete')}}" class="payment-main" method="POST">
            @csrf
            @method('POST')
            <div class="payment-body__wrap">
                <div class="form-back">
                    {{-- <button type="submit" name="back" class="back" id="back" value="backPayment">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button> --}}
                    <a href="{{route('payNow.index')}}"><i class="fa-solid fa-arrow-left"></i></a>
                </div>
                <div class="payment-detail">
                    <div class="form-group">
                        <label class="form-label" for="name">氏名:</label>
                        <span class="form-label">{{old('name',$user['name'])}}</span>
                        <input class="form-input" type="hidden" name="name" id="name" value="{{$user['name']}}">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="name">電話番号:</label>
                        <span class="form-label">{{old('phone',$data['phone'])}}</span>
                        <input class="form-input" type="hidden" name="phone" id="phone" value="{{$data['phone']}}">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="name">メールアドレス:</label>
                        <span class="form-label">{{old('email',$data['email'])}}</span>
                        <input class="form-input" type="hidden" name="email" id="email" value="{{$data['email']}}">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="name">住所:</label>
                        <span class="form-label">{{old('address',$data['address'])}}</span>
                        <input class="form-input" type="hidden" name="address" id="address"
                            value="{{$data['address']}}">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="deli_time">デリバリー:</label>
                        <span class="form-label">{{old('deli_time',$data['deli_time'])}}</span>
                        <input class="form-input" type="hidden" name="deli_time" id="deli_time"
                            value="{{$data['deli_time']}}">
                    </div>
                    <div class="form-group" style="padding-bottom: 0">
                        <label for="pay" class="form-label">決済方法:</label>
                        <div class="pay-item__wrap">
                            @php
                            if (session()->has('card') !== null) (
                            $card = session()->get('card')
                            )
                            @endphp
                            <div class="pay-item">
                                <input type="hidden" name="pay" class="form-control" value="{{$data['pay']}}">
                                <span>{{$data['pay']}}</span>
                            </div>

                        </div>
                        @if ($data['pay'] == 'card')
                        <div id="card-info">
                            <h4>カード情報</h4>
                            <div class="card-info__item">
                                <label for="card_number">カードナンバー:</label>
                                <input type="hidden" id="card_number" name="card_number"
                                    value="{{ $card['card_number'] }}">
                                <span>{{ $card['card_number'] }}</span>
                            </div>
                            <div class="card-info__item">
                                <label for="expiration_date">有効期限:</label>
                                <input type="hidden" id="expiration_date" name="expiration_date"
                                    value="{{ $card['expiration_date'] }}">
                                <span>{{ $card['expiration_date'] }}</span>
                            </div>
                            <div class="card-info__item">
                                <label for="cvv">CVV:</label>
                                <input type="hidden" id="cvv" name="cvv" value="{{ $card['cvv'] }}">
                                <span>{{ $card['cvv'] }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="order-detail">
                    <h3>ご注文</h3>
                    <div class="order-detail__wrap">
                        <div class="order-group order-product__title">
                            <h4>商品名</h4>
                            <h4>総価格</h4>
                        </div>
                        <ul class="order-list">
                            <li class="order-group">
                                <div>
                                    <span class="order-name">{{$data['name']}}</span>
                                    <span class="order-quantity">x{{$data['quantity']}}</span>
                                </div>
                                <div class="order-price__one">
                                    <span>{{$data['price']}}</span>
                                    <span>円</span>
                                </div>
                            </li>
                        </ul>
                        <div class="order-price">
                            <div class="order-price__all">
                                <div>ご注文合計（税抜）</div>
                                <div>{{$data['price']*$data['quantity']}}円</div>
                            </div>
                            <div class="order-price__tax">
                                <div>消費税</div>
                                <div>{{$data['price']*$data['quantity']*0.1}}円</div>
                            </div>
                            <div class="order-price__final">
                                <div>ご注文合計（税込）</div>
                                <div>{{$data['price']*$data['quantity']*1.1}}円</div>
                                <input type="hidden" name="totalPrice" value="{{$data['price']*$data['quantity']*1.1}}">
                                <input type="hidden" name="product_id" value="{{$data['id']}}">
                                <input type="hidden" name="quantity" value="{{$data['quantity']}}">
                                <input type="hidden" name='total_money' value="{{$data['price']*$data['quantity']*1.1}}">
                            </div>
                        </div>
                    </div>
                    <button class="submit" type="submit" id="submit" value="submit" name="submit">確認</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection