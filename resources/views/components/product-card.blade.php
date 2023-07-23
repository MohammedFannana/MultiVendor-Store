<!-- image and salePercent use Accessors in produt Model -->
<!-- Start Single Product -->
<div class="single-product">
    <!-- image has three status 1-no image 2-out image صورة خارجية رابط   -->
    <!-- 3- uplode image صورة عندي محملة على الجهاز -->
    <!-- any inside path use asset() -->
    <!-- for this 3 status use Accessors  -->
    <!--Accessors image_url define in model product -->
    <div class="product-image">
        <img src="{{  $product->image_url }}" alt="#">

        <!--Accessors SalePercent define in model product -->
        <!-- Accessors invoke sale_percent -->

        @if($product->sale_percent)
        <span class="sale-tag">{{$product->sale_percent}}%</span>
        @endif

        @if($product->new)
        <span class="new-tag">New</span>
        @endif
        <div class="button">
            <a href="{{route('products.show',$product->id)}}" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
        </div>
    </div>
    <div class="product-info">
        <!-- to get category for product usr relation -->
        <span class="category">{{$product->category->name}}</span>
        <h4 class="title">
            <a href="{{route('products.show' ,$product->slug)}}">{{$product->name}}</a>
        </h4>
        <ul class="review">
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star-filled"></i></li>
            <li><i class="lni lni-star"></i></li>
            <li><span>4.0 Review(s)</span></li>
        </ul>
        <div class="price">
            <span>{{Currency::format($product->price)}}</span>

            @if($product->compare_price)
            <span class="discount-price"> {{Currency::format($product->compare_price)}} </span>
            @endif
        </div>
    </div>
</div>
<!-- End Single Product -->