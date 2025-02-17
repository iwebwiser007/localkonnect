  <!-- <div class="ps-top-categories mt-40 mb-40">
    <div class="ps-container">
        <h3>{!! BaseHelper::clean($title) !!}</h3>
        <div class="row justify-content-center">
            @foreach($categories as $category)
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                    <div class="ps-block--category">
                        <a class="ps-block__overlay" href="{{ $category->url }}"></a>
                        <img class="category-image" src="{{ RvMedia::getImageUrl($category->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $category->name }}"/>
                        <p>{{ $category->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>   -->

<!--  
  <div id="categorySlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">
        @foreach($categories->chunk(6) as $key => $chunk) 
            <div class="carousel-item @if($key == 0) active @endif">
                <div class="row">
                    @foreach($chunk as $category)
                        <div class="col-md-2 text-center">
                            <div class="ps-block--category">
                                <a class="ps-block__overlay" href="{{ $category->url }}"></a>
                                <img class="category-image img-fluid" 
                                    src="{{ RvMedia::getImageUrl($category->image, 'small', false, RvMedia::getDefaultImage()) }}" 
                                    alt="{{ $category->name }}"/>
                                <p>{{ $category->name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>       -->


<div class="ps-top-categories mt-40 mb-40">
    <div class="ps-container-fluid">
        <h3>{!! BaseHelper::clean($title) !!}</h3>

        <!-- Bootstrap Carousel for Full-Screen Infinite Slider -->
        <div id="categorySlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000" data-bs-wrap="true">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row justify-content-between">
                        @foreach($categories->take(8) as $category)
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                                <div class="ps-block--category">
                                    <a class="ps-block__overlay" href="{{ $category->url }}"></a>
                                    <img class="category-image img-fluid" 
                                        src="{{ RvMedia::getImageUrl($category->image, 'small', false, RvMedia::getDefaultImage()) }}" 
                                        alt="{{ $category->name }}"/>
                                    <p>{{ $category->name }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Add more carousel items for next slides -->

                <div class="carousel-item active">
                    <div class="row justify-content-between">
                        @foreach($categories->take(8) as $category)
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                                <div class="ps-block--category">
                                    <a class="ps-block__overlay" href="{{ $category->url }}"></a>
                                    <img class="category-image img-fluid" 
                                        src="{{ RvMedia::getImageUrl($category->image, 'small', false, RvMedia::getDefaultImage()) }}" 
                                        alt="{{ $category->name }}"/>
                                    <p>{{ $category->name }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>








