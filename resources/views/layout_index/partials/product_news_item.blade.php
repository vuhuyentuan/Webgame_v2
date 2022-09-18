@foreach ($product_news as $product_new)
<div class="blog-item">
    <div class="blog-thumb">
        <img src="{{ asset($product_new->image) }}" width="350px" height="250px" alt="">
    </div>
    <div class="blog-text text-box text-white">
        <h3>{{$product_new->name}}</h3>
        <p>{{$product_new->short_des}}</p>
        <a href="#" class="read-more">{{__('Read More')}}  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
    </div>
</div>
@endforeach
