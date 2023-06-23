@extends('drugstore.app')
@php /* dd($cart); */@endphp
{{-- @foreach ($cart->products as $product)
<p>{{$product['quantity']}}</p>
<p>{{$product['price']}}</p>
<p>{{$product['productInfo']->id}}</p>
<br>
@endforeach --}}

@section('title', '会計')

@section('header')
@include('drugstore.header.userHeader', ['user' => $user])
@endsection
@section('main-content')
<div class="app-container">
    <div class="product-wrap">
        <h1 class="product-title">決済</h1>
        <form action="{{route('payment.send')}}" class="payment-main" method="POST">
            @csrf
            @method('POST')
            <div class="payment-body__wrap">
                <div class="payment-detail">
                    <p><span class="red">*</span>は必須項目となります。</p>
                    <div class="form-group">
                        <label class="form-label" for="phone">電話番号<span class="red">*</span></label>
                        @if($errors->has('phone'))
                        <span class="form-message error">{{ $errors->first('phone') }}</span>
                        @endif
                        @if (session()->has('back.phone') != null)
                        <input class="form-input" type="text" placeholder="0123456789" name="phone" id="phone"
                            value="{{session()->get('back.phone')}}">
                        @else
                        <input class="form-input" type="text" placeholder="0123456789" name="phone" id="phone"
                            value="{{old('phone')}}">
                        @endif
                        @if ($user->phone !== null)
                        <input class="form-checkbox" type="checkbox" name="phone" id="ifphone" value="{{$user->phone}}">
                        <span style="font-size: 1.4rem;">登録した電話番号をご使用</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">メールアドレス<span class="red">*</span></label>
                        @if($errors->has('email'))
                        <span class="form-message error">{{ $errors->first('email') }}</span>
                        @endif
                        @if (session()->has('back.email') != null)
                        <input class="form-input" type="text" placeholder="test@test.co.jp" name="email" id="email"
                            value="{{session()->get('back.email')}}">
                        @else
                        <input class="form-input" type="text" placeholder="test@test.co.jp" name="email" id="email"
                            value="{{old('email')}}">
                        @endif
                        <input class="form-checkbox" type="checkbox" name="email" id="ifemail" value="{{$user->email}}">
                        <span style="font-size: 1.4rem;">登録したメールアドレスをご使用</span>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="address">住所<span class="red">*</span></label>
                        @if($errors->has('address.address'))
                        <span class="form-message error">{{ $errors->first('address') }}</span>
                        @endif
                        @if (session()->has('back') != null)
                        <input class="form-input" type="text" placeholder="東京都荒川区西日暮里1-1-1" name="address" id="address"
                            value="{{session()->get('back.address')}}">
                        @else
                        <input class="form-input" type="text" placeholder="東京都荒川区西日暮里1-1-1" name="address" id="address"
                            value="{{old('address')}}">
                        @endif
                        @if ($user->address !== null)
                        <input class="form-checkbox" type="checkbox" name="address" id="ifaddress"
                            value="{{$user->address}}">
                        <span style="font-size: 1.4rem;">登録した住所をご使用</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="deli_time">デリバリー</label>
                        @if (session()->has('back.deli_time') != null)
                        <input class="form-input" type="date" name="deli_time" id="deli_time"
                            value="{{session()->get('back.deli_time')}}" min="{{ date('Y-m-d') }}">
                        @else
                        <input class="form-input" type="date" name="deli_time" id="deli_time" min="{{ date('Y-m-d') }}">
                        @endif
                    </div>
                    <div class="form-group" style="padding-bottom: 0">
                        <label for="pay" class="form-label">決済方法<span class="red">*</span></label>
                        @if($errors->has('pay'))
                        <span class="form-message error">{{ $errors->first('pay') }}</span>
                        @endif
                        <div class="pay-item__wrap">
                            <div class="pay-item">
                                <input type="radio" name="pay" class="form-control" value="after" id='pay-after' {{
                                    old('pay')=='after' || session()->get('back.pay')=='after'?'checked':'' }}>
                                <span>直接支払い</span>
                            </div>
                            <div class="pay-item">
                                <input type="radio" name="pay" class="form-control" value="card" id="pay-card" {{
                                    old('pay')=='card' || session()->get('back.pay')=='card'?'checked':'' }}>
                                <span>VISAカード</span>
                            </div>
                            <div class="pay-item">
                                <input type="radio" name="pay" class="form-control" value="other" id="pay-other" {{
                                    old('pay')=='other' || session()->get('back.pay')=='other'?'checked':'' }}>
                                <span>other</span>
                            </div>
                        </div>

                        <div id="card-info" style="display: none;">
                            <h4>カード情報</h4>
                            <div class="card-info__item">
                                <label for="card_number">カードナンバー:</label>
                                @if (session()->has('back.card_number') != null)
                                <input type="text" id="card_number" name="card_number"
                                    value="{{session()->get('back.card_number')}}">
                                @else
                                <input type="text" id="card_number" name="card_number" value="{{ old('card_number') }}">
                                @endif
                            </div>
                            <div class="card-info__item">
                                <label for="expiration_date">有効期限:</label>
                                @if (session()->has('back.expiration_date') != null)
                                <input type="text" id="expiration_date" name="expiration_date"
                                    value="{{session()->get('back.expiration_date')}}">
                                @else
                                <input type="text" id="expiration_date" name="expiration_date" value="{{ old('expiration_date') }}">
                                @endif
                            </div>
                            <div class="card-info__item">
                                <label for="cvv">CVV:</label>
                                @if (session()->has('back.cvv') != null)
                                <input type="text" id="cvv" name="cvv"
                                    value="{{session()->get('back.cvv')}}">
                                @else
                                <input type="text" id="cvv" name="cvv" value="{{ old('cvv') }}">
                                @endif
                            </div>


                        </div>
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
                            @foreach ($cart->products as $product)
                            <li class="order-group">
                                <div>
                                    <span class="order-name">{{$product['productInfo']->name}}</span>
                                    <span class="order-quantity">x{{$product['quantity']}}</span>
                                </div>
                                <div class="order-price__one">
                                    <span>{{$product['price']/$product['quantity']}}</span>
                                    <span>円</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <div class="order-price">
                            <div class="order-price__all">
                                <div>ご注文合計（税抜）</div>
                                <div>{{$cart->totalPrice}}円</div>
                            </div>
                            <div class="order-price__tax">
                                <div>消費税</div>
                                <div>{{$cart->totalPrice*0.1}}円</div>
                            </div>
                            <div class="order-price__final">
                                <div>ご注文合計（税込）</div>
                                <div>{{$cart->totalPrice*1.1}}円</div>
                            </div>
                        </div>
                    </div>
                    <button class="submit" type="submit" id="submit" value="submit" name="submit">送信</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection