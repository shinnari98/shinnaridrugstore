@php
$like_db = [];
if (Auth::user() && $likes != null && $likes != []) {
if (count($likes) > 0) {
foreach ($likes as $like) {
    $like_db[] = $like->product_id;
}}}
@endphp

<div class="product">
    @if(!empty($typeProduct))
    <h3 class="product-title">{{$typeProduct}}</h3>
    @else
    <h3 class="product-title">全商品</h3>
    @endif
    {{-- <div class="product-filter">
        <span class=" filter__label">並べ</span>
        <button class=" filter__btn btn btn-primary">新商品</button>
        <button class=" filter__btn btn">人気</button>
        <div class="select-input">
            <span class="select-input__label">並べ</span>
            <i class="select-input__icon fa-sharp fa-solid fa-chevron-down"></i>
            <ul class="select-input__list">
                <li class="select-input__item">
                    <a href="" class="select-input__link">新商品</a>
                </li>
                <li class="select-input__item">
                    <a href="" class="select-input__link">人気</a>
                </li>
            </ul>
        </div>

        <div class="filter__page">
            <span class="filter__page-number">
                <span class="filter__page-current">1</span>/14
            </span>

            <div class="filter__page-control">
                <a href="" class="filter__page-btn filter__page-btn-disabled">
                    <i class="filter__page-icon fa-sharp fa-solid fa-chevron-left"></i>
                </a>
                <a href="" class="filter__page-btn">
                    <i class="filter__page-icon fa-sharp fa-solid fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div> --}}

    <div class="product-list">
        @foreach ($products as $product)
        @if(!empty($typeProduct))

        @if (Auth::user())
        @if (Auth::user()->permission_id == 1)
        <a class=" product-item" href="{{ route('product.show',['product'=>$product->id,'type'=>$typeProduct ]) }}">
            @else
            <a class=" product-item" href="{{ route('product.showUser',['id'=>$product->id,'type'=>$typeProduct]) }}">
                @endif
                @else
                <a class=" product-item" href="{{ route('product.showUser',['id'=>$product->id,'type'=>$typeProduct]) }}">
                    @endif

        @else

        @if (Auth::user())
        @if (Auth::user()->permission_id == 1)
        <a class=" product-item" href="{{ route('product.show',['product'=>$product->id]) }}">
            @else
            <a class=" product-item" href="{{ route('product.showUser',['id'=>$product->id]) }}">
                @endif
                @else
                <a class=" product-item" href="{{ route('product.showUser',['id'=>$product->id]) }}">
                    @endif

                    @endif
                    <div class="product-item__img"
                        style="background-image: url('{{asset('img/product_img/'.$product->image)}}');">
                    </div>
                    <h4 class="product-item__name">{{$product->name}}</h4>

                    @if ($product->sale_off > 0)
                    <div class="product-item__price">
                        <div class="item__price-old">{{$product->price}}</div>
                        <div class="item__price-current">
                            <span style="font-size: 1rem;color: var(--text-color);">(税込)</span>
                            {{round($product->price*(100-$product->sale_off)/100)}}
                        </div>
                    </div>
                    @else
                    <div class="product-item__price" style="justify-content: center">
                        <p style="color: var(--text-color);margin-right:5px;">(税込)</p>
                        <div class="item__price-current"> {{$product->price}}</div>
                    </div>
                    @endif

                    <div class="product-item__action">
                        <span class="product-item__like {{-- product-item__like--liked --}}">
                            @php
                            if (Auth::user() ) {
                            $liked = in_array($product->id, $like_db);
                            }
                            $likes = session()->get('likes');
                            $productLiked = isset($likes[$product->id]) && $likes[$product->id] === true;
                            @endphp

                            @if (Auth::user())
                            @if ($productLiked || $liked)
                            <i class="product-item__like-icon-empty fa-regular fa-heart" style="display:none;"></i>
                            <i class="product-item__like-icon-fill fa-solid fa-heart"></i>
                            @else
                            <i class="product-item__like-icon-empty fa-regular fa-heart"></i>
                            <i class="product-item__like-icon-fill fa-solid fa-heart" style="display:none;"></i>
                            @endif
                            @else
                            @if ($productLiked )
                            <i class="product-item__like-icon-empty fa-regular fa-heart" style="display:none;"></i>
                            <i class="product-item__like-icon-fill fa-solid fa-heart"></i>
                            @else
                            <i class="product-item__like-icon-empty fa-regular fa-heart"></i>
                            <i class="product-item__like-icon-fill fa-solid fa-heart" style="display:none;"></i>
                            @endif
                            @endif
                        </span>
                        <div class="product-item__rating">
                            <span class="item__rating-number">{{$product->star}}</span>
                            @for ($i = 0; $i < $product->star; $i++)
                                <i class="product-item__star--gold fa-solid fa-star"></i>
                                @endfor
                                @php
                                $remain = 5 - $product->star;
                                @endphp
                                @for ($i = 0; $i < $remain; $i++) <i class="fa-solid fa-star"></i>
                                    @endfor
                        </div>
                        <span class="product-item__sold">{{$product->sold}}</span>
                    </div>
                    <div class="product-item__producer">
                        @if (!empty($product->producer->nickname))
                        <span>{{$product->producer->nickname}}</span>
                        @endif
                    </div>

                    @if (in_array($product->id, $famous));
                    <div class="product-item__favourite">
                        <i class="fa-solid fa-check"></i>
                        <span>人気</span>
                    </div>
                    @endif

                    @if ($product->sale_off > 0)
                    <div class="product-item__sale">
                        <span class="product-item__sale-off-persent">{{$product->sale_off}}%</span>
                        <span class="product-item__sale-off-label">OFF</span>
                    </div>
                    @endif
                </a>
                @endforeach

    </div>
    <div class="paging">
        {{ $products->links() }}
    </div>
</div>