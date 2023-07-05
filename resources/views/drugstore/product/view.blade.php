
@extends('drugstore.app')

@section('title', '商品詳細')

@section('header')
@if(($user || isset($user)))

@if ($user->permission_id==1)
@include('drugstore.header.adminHeader')
@elseif ($user->permission_id==2)
@include('drugstore.header.producerHeader')
@else
@include('drugstore.header.userHeader')
@endif

@else
@include('drugstore.header.header')
@endif
@endsection

@section('main-content')
<div class="app-container">
    <div class="product-wrap">
        <div class="back">
            @if (!empty($typeId))
            <a href="{{route('product.type',['id' => $typeId])}}"><i class="fa-solid fa-arrow-left"></i></a>

            @else
            @if (Auth::user())
            <a href="{{route('homepage')}}"><i class="fa-solid fa-arrow-left"></i></a>
            @else
            <a href="{{route('index')}}"><i class="fa-solid fa-arrow-left"></i></a>
            @endif
            @endif
        </div>
        <h1 class="product-title">商品詳細</h1>
        <div class="product-main">
            <div class="product-image">
                <img src="{{ asset('img/product_img/' . $data->image) }}" alt="">
            </div>
            <div class="product-info">
                <div class="product-name">{{ $data->name }}</div>
                <div class="product-item__action">
                    <span class="product-item__like product-item__like--liked" data-product-id="{{$data->id}}">
                        @php
                        $likes = session()->get('likes');
                        // $user = session()->get('user');
                        $productLiked = isset($likes[$data->id]) && $likes[$data->id] === true;
                        $like_db = $like ? true : false
                        @endphp

                        @if ($productLiked || $like_db)
                        {{-- check theo session ban dau --}}
                        <i id="like-icon-empty" class="product-item__like-icon-empty fa-regular fa-heart"
                            style="display:none;"></i>
                        <i id="like-icon-fill" class="product-item__like-icon-fill fa-solid fa-heart"></i>
                        @else

                        <i id="like-icon-empty" class="product-item__like-icon-empty fa-regular fa-heart"></i>
                        <i id="like-icon-fill" class="product-item__like-icon-fill fa-solid fa-heart"
                            style="display:none;"></i>
                        @endif
                    </span>
                    <div class="product-item__rating">
                        <span class="item__rating-number">{{$data->star}}</span>
                        @for ($i = 0; $i < $data->star; $i++)
                            <i class="product-item__star--gold fa-solid fa-star"></i>
                            @endfor
                            @php
                            $remain = 5 - $data->star;
                            @endphp
                            @for ($i = 0; $i < $remain; $i++) <i class="fa-solid fa-star"></i>
                                @endfor
                    </div>
                    <span class="product-item__sold">({{$data->sold}})</span>
                </div>
                <div class="product-price">
                    @if ($data->sale_off > 0)
                    <div class="product-price__old">
                        <span class="price__old-tittle">過去価格: </span>
                        <span class="price__old-number">{{ number_format($data->price) }}円</span>
                    </div>
                    <div class="product-price__sale">
                        <span class="price__sale-tittle">タイムセール: </span>
                        <span style="color: var(--text-color);margin-right:5px;font-size:1.6rem">(税込)</span>
                        <span class="price__sale-number">{{ number_format(round($data->price * (100 - $data->sale_off) / 100))
                            }}円</span>
                    </div>
                    @else
                    <div class="product-price__sale">
                        <span class="price__sale-tittle">価格: </span>
                        <span style="color: var(--text-color);margin-right:5px;font-size:1.6rem">(税込)</span>
                        <span class="price__sale-number">{{ number_format($data->price) }}円</span>
                    </div>
                    @endif
                </div>
                <div class="product-description">
                    <p style="white-space: pre-line;">{{$data->description}}</p>
                </div>
                @if (!Auth::user() || (Auth::user() && Auth::user()->permission_id == 3))
                <div class="product-footer">
                    <form action="{{route('payment.now')}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="product-quantity">
                            <div class="product-quantity__minus">-</div>
                            <div class="product-quantity__number">
                                <input type="number" name="quantity" value="1">
                            </div>
                            <div class="product-quantity__plus">+</div>
                        </div>
                        <div class="product-button">
                            <div class="product-inCart">
                                <a onclick="addCart(event,{{$data->id}})" href="">カートに入れる</a>
                            </div>
                            <div class="product-buy">
                                @if ($user)
                                <input type="hidden" name="id" value="{{$data->id}}">
                                <input type="hidden" name="name" value="{{$data->name}}">
                                <input type="hidden" name="price"
                                    value="{{round($data->price*(100 - $data->sale_off)/100)}}">
                                <button name="submit" type="submit">すぐに買う</button>

                                @else
                                <a href="{{route('get.login')}}">すぐに買う</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        const token = "{{ csrf_token() }}";
        console.log(token);
    </script>


</div>
@endsection