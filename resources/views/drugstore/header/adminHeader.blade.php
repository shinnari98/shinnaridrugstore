<header>
    <div class="nav-bar">
        <div class="nav-logo">
            <a class="nav-logo" href="{{route('homepage')}}">
                <img src="{{asset('./img/logo.PNG')}}" class="nav-logo__img" alt="logo">
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

        <div class="nav-group" style="flex-direction: row-reverse;">
            <div class=" nav-login">
                <i class="user-icon fa-solid fa-circle-user"></i>
                <span class="user-name">Admin</span>
                <div class="user-menu">
                    <div class="user-menu__item"><a href="{{route('user.index')}}">ユーザー管理</a></div>
                    <div class="user-menu__item"><a href="{{route('product.index')}}">商品管理</a></div>
                    <div class="user-menu__item"><a href="{{route('order.index')}}">注文履歴管理</a></div>
                    <div class="user-menu__item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">ログアウト</button>
                        </form>
                    </div>
                    {{-- <x-header type='3'></x-header>  --}}             {{-- component --}}
                </div>
            </div>

            <div class=" nav-contact">
                <a href="{{route('contact.index')}}" class="">全問い合わせ</a>
            </div>

            <div class="re-navbar">
                <div class="re-navbar__icon">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <div class="re-navbar__menu">
                    <div class="user-menu__item"><a href="{{route('user.index')}}">ユーザー管理</a></div>
                    <div class="user-menu__item"><a href="{{route('product.index')}}">商品管理</a></div>
                    <div class="user-menu__item"><a href="{{route('order.index')}}">注文履歴管理</a></div>
                    <div class="user-menu__item"><a href="{{route('contact.index')}}">全問い合わせ</a></div>
                    <div class="user-menu__item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">ログアウト</button>
                        </form>
                    </div>
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
        <a href="{{route('admin.productType',['id' => $item->id])}}" class="sub-bar__item">
            <span class="sub-bar__title">{{$item->name}}</span>
            <i class="fa-solid fa-chevron-down"></i>
        </a>
        @endforeach
    </div>
</header>
@include('drugstore.item.ajaxJS')
<script>
    /* function updateNavGroupStyle() {
        if ($(window).width() <= 992) {
            console.log($(window).width());
            $('.nav-group').css('flex-direction', 'row-reverse');
        } else {
            $('.nav-group').css('flex-direction', 'row');
        }
    }
    $(window).resize(updateNavGroupStyle);
    updateNavGroupStyle(); */
</script>