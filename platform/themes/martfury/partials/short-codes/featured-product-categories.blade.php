<div class="ps-top-categories mt-40 mb-40">
    <div class="ps-container">
        <h3>{!! BaseHelper::clean($title) !!}</h3>
        <div class="owl-carousel owl-theme category-slider">
            @foreach($categories as $category)
                <div class=" item">
                    <div class="ps-block--category">
                        <a class="ps-block__overlay" href="{{ $category->url }}"></a>
                        <img class="category-image category-image mx-auto mb-1" src="{{ RvMedia::getImageUrl($category->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $category->name }}"/>
                        <p>{{ $category->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
