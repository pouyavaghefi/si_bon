<div>
    <span class="product-name">
        <h1>{{ $product->title }}</h1>
    </span>

    @if($product->category)
        <span class="product-name">
            <span class="pr-2">دسته بندی :</span>
            <span>
                <a href="{{ route('front.shop.categories', $product->category->slug) }}">
                    {{ $product->category->title }}
                </a>
            </span>
        </span>
    @endif

    @if($product->brand)
        <span class="product-name">
            <span class="pr-2">برند :</span>
            <span>
                <a href="#">
                    {{ $product->brand->title }}
                </a>
            </span>
        </span>
    @endif

    <span class="ratings"></span>

    @if($product->show_price)
        <span class="price-sing">
            {{ number_format($product->discount_price ?? $product->price) }}
            تومان
        </span>
    @endif
</div>

<div style="margin: -11px 0 21px;" class="lbsingle"></div>
