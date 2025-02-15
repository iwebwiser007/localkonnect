<div class="ps-page--single ps-page--vendor">
    <section class="ps-store-list">
        <div class="container">
            @php $coverImage = $store->getMetaData('cover_image', true); @endphp
          
            <div class="ps-section__wrapper">
                <div class="ps-shopping ps-tab-root">
                        <div class="ps-section__search">
                            <div class="mb-3">
                                <form
                                    class="products-filter-form-vendor"
                                    action="{{ URL::current() }}"
                                    method="GET"
                                >
                                    <div class="form-group mb-5">
                                        <button><i class="icon-magnifier"></i></button>
                                        <input class="form-control" name="q" value="{{ BaseHelper::stringify(request()->query('q')) }}" type="text" placeholder="{{ __('Search in this store...') }}">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="ps-shopping__header">
                            <p><strong> {{ $products->total() }}</strong> {{ __('Products found') }}</p>
                            <div class="ps-shopping__actions">
                                <div class="ps-shopping__view">
                                    <p>{{ __('View') }}</p>
                                    <ul class="ps-tab-list">
                                        <li class="active"><a href="#tab-1"><i class="icon-grid"></i></a></li>
                                        <li><a href="#tab-2"><i class="icon-list4"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <div class="ps-tabs">
                        <div class="ps-tab active" id="tab-1">
                            <div class="ps-shopping-product">
                                <div class="row">
                                    @if ($products->isNotEmpty())
                                        @foreach($products as $product)
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                                <div class="ps-product">
                                                    {!! Theme::partial('product-item', compact('product')) !!}
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="ps-pagination">
                                {!! $products->withQueryString()->links() !!}
                            </div>
                        </div>
                        <div class="ps-tab" id="tab-2">
                            <div class="ps-shopping-product">
                                @if ($products->count() > 0)
                                    @foreach($products as $product)
                                        <div class="ps-product ps-product--wide">
                                            {!! Theme::partial('product-item-grid', compact('product')) !!}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="ps-pagination">
                                {!! $products->withQueryString()->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
