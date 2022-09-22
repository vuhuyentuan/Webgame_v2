@foreach ($product_news as $product_new)
{{-- <div class="blog-item">
    <div class="blog-thumb">
        <img src="{{ asset($product_new->image) }}" width="100%" height="250px" alt="">
    </div>
    <div class="blog-text text-box text-white">
        <h3>{{$product_new->name}}</h3>
        <p>{{$product_new->short_des}}</p>
        <a href="{{ route('games', 'all') }}" class="read-more">{{__('Read More')}}  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
    </div>
</div><br> --}}
<div class="d-flex mt-4 ml-4 mr-4 mb-2">
    <div class="flex-shrink-0">
        <div class="image">
            <a href="{{ route('game.detail', $product_new->id) }}">
                <img src="{{ asset($product_new->image) }}" width="300px" height="250px" alt="">
            </a>
        </div>
    </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="blog-text text-box text-white">
        <a href="{{ route('game.detail', $product_new->id) }}">
            <h3>{{$product_new->name}}</h3>
        </a>
        <p>{{$product_new->short_des}}</p>
        <a href="{{ route('game.detail', $product_new->id) }}" class="read-more">{{__('Detail')}}  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
    </div>
</div>
@endforeach
