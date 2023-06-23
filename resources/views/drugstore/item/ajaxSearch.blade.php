<h3 class="nav-search__history-heading">SEARCH HISTORY</h3>
<ul class="nav-search__history-list">
    @foreach ($data as $pro)
    <li class="nav-search__history-item">
        <a href="{{ url('./product/'.$pro->id)}}">
            <img src="{{url('img/product_img/'.$pro->image)}}">
            <span>{{$pro->name}}</span>
        </a>
    </li>

    @endforeach
</ul>