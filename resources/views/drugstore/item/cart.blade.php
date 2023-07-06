@php
// dd($newCart);
@endphp
{{-- <p>YES</p> --}}
@if (session()->has('cart') != null )

<h4 class="nav-cart__heading">カートに入れた商品</h4>
<ul class="nav-cart__menu">
    @foreach (session()->get('cart')->products as $item)
    @php
    // print_r($item);
    @endphp
    <li class="cart__list">
        <img class="cart__list-img" src="{{ asset('img/product_img/' . $item['productInfo']->image) }}" alt="">
        <div class="cart__list-info">
            <h5 class="cart__list-name"><a
                    href="{{ url('./product/' .$item['productInfo']->id)}}">{{$item['productInfo']->name}}</a></h5>
            <ul class="cart__list-priceWrap">
                <li class="cart__list-price">{{ number_format($item['productInfo']->price*(100-$item['productInfo']->sale_off)/100) }}円
                </li>
                <li class="cart__list-multy">x</li>
                <li class="cart__list-quantity">
                    {{-- <span class="quantity-minus">-</span> --}}
                    <span class="quantity-number" data-quantity="{{$item['quantity']}}">{{$item['quantity']}}</span>
                    {{-- <span class="quantity-plus">+</span> --}}
                </li>
            </ul>
        </div>
        <div class="cart__list-delete">
            <i class="fa-solid fa-trash" data-id="{{$item['productInfo']->id}}"></i>
        </div>
    </li>
    @endforeach
</ul>
<div class="nav-cart-footer">
    <div class="cart__all-price">
        <span class="all-price__text">ご請求額: </span>
        <span class="all-price__number">{{number_format(session()->get('cart')->totalPrice)}}円</span>
        <input hidden id="all-cart__number" type="number" value="{{session()->get('cart')->totalQuantity}}">
    </div>
    @if (Auth::user())
    <div class="cart__payment"><a href="{{route('payment')}}">レジに進む</a></div>
    @else
    <div class="cart__payment"><a href="{{route('get.login')}}">レジに進む</a></div>
    @endif
</div>
@else
<h4 class="nav-cart__heading">カートに入れた商品はありません。</h4>
@endif