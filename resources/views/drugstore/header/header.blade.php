<header>
    <div class="nav-bar">
        <div class="nav-logo">
            <a class="nav-logo" href="{{route('index')}}">
                <img src={{asset('./img/logo.PNG')}} class="nav-logo__img" alt="logo">
                <div class="nav-logo__name">SHINNARI <br> DRUGSTORE</div>
            </a>
        </div>

        <div class=" nav-search">
            <form action="" class="nav-search__form">
                <div class="form-group">
                    <input class="nav-search__input" type="text" placeholder="Search key">
                </div>
            </form>

            <!-- search history -->
            <div class="nav-search__history">

            </div> 
        </div>

        <div class="nav-re-search">
            <div class="nav-re-search__btn">
                <i class="fa-solid fa-magnifying-glass nav-search__icon"></i>
            </div>

        </div>

        <div class="nav-group">
            <div class=" nav-contact">
                <a href="{{route('contact.userIndex')}}" class="">問い合わせ</a>
            </div>

            <div class="nav-cart ">
                <i class="fa-solid fa-cart-shopping "></i>
                <span class="nav-cart__notice">
                    {{ optional(session()->get('cart'))->totalQuantity ?? 0 }}
                </span>
                <div class="nav-cart__table">
                    <div id="nav-cart__wrap">
                        {{-- <p>NO</p> --}}
                        @if(session()->has('cart') != null)
                        @php
                        $cart = session()->get('cart');
                        // dd($cart);
                        @endphp
                        <h4 class="nav-cart__heading">カートに入れた商品</h4>
                        <ul class="nav-cart__menu">
                            @foreach (session()->get('cart')->products as $item)
                            @php
                            // print_r($item);
                            @endphp
                            <li class="cart__list">
                                <img class="cart__list-img"
                                    src="{{ asset('img/product_img/' . $item['productInfo']->image) }}" alt="">
                                <div class="cart__list-info">
                                    <h5 class="cart__list-name"><a
                                            href="{{ url('./product/' .$item['productInfo']->id)}}">{{$item['productInfo']->name}}</a>
                                    </h5>
                                    <ul class="cart__list-priceWrap">
                                        <li class="cart__list-price">{{
                                            $item['productInfo']->price*(100-$item['productInfo']->sale_off)/100 }}円
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
                                <span class="all-price__number">{{session()->get('cart')->totalPrice}}円</span>
                                {{-- <input hidden id="all-cart__number" type="hidden" value="{{session()->get('cart')->totalQuantity}}"> --}}
                            </div>
                            <div class="cart__payment">
                                <a href="{{route('get.login')}}">レジに進む</a>
                            </div>
                        </div>
                        @else
                        <h4 class="nav-cart__heading">カートに入れた商品はありません。</h4>
                        @endif
                    </div>

                </div>
            </div>

            <div class=" nav-login">
                <span class="login-btn"><a href="{{ url('login') }}">ログイン</a></span>
            </div>

            <div class="re-navbar">
                <div class="re-navbar__icon">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <div class="re-navbar__menu">
                    <div class="re-navbar__contact">
                        <a href="{{route('contact.userIndex')}}" class="">問い合わせ</a>
                    </div>
                    <div class="re-navbar__login"><a href="{{ url('login') }}">ログイン</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="nav-bigSearch__wrap">
        <span class="nav-bigSearch__back"><i class="fa-solid fa-arrow-left"></i></span>
        <div class="nav-bigSearch">
            <input class="nav-search__input" type="text" placeholder="Search key">
            {{-- <button class="nav-search__btn" type="button">
                <i class="fa-solid fa-magnifying-glass nav-search__icon"></i>
            </button> --}}
        </div>
        <div class="nav-search__history">

        </div> 
    </div>

    <div class="modall">
        <div class="overlay-search">

        </div>
    </div>
    <div class="sub-bar">
        @foreach ($categories as $item)
        <a href="{{route('product.type',['id' => $item->id])}}" class="sub-bar__item 
            @if (!empty($typeProduct) && $typeProduct == $item->name) sub-bar__in @endif">
            <span class="sub-bar__title">{{$item->name}}</span>
            <i class="fa-solid fa-chevron-down"></i>
        </a>
        @endforeach
    </div>
</header>

@include('drugstore.item.ajaxJS')
