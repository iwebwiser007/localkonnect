{!! Theme::partial('header-meta') !!}
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<body @if (Theme::get('pageId')) id="{{ Theme::get('pageId') }}" @endif
    @if (BaseHelper::isRtlEnabled()) dir="rtl" @endif>
    {!! apply_filters(THEME_FRONT_BODY, null) !!}
    <div id="alert-container"></div>

    @if (theme_option('preloader_enabled', 'no') == 'yes')
        <div id="loader-wrapper">
            <div class="preloader-loading"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
    @endif

    {!! Theme::get('topHeader') !!}

    <header class="header header--1"
        data-sticky="{{ Theme::get('stickyHeader', theme_option('sticky_header_enabled', 'yes') == 'yes' ? 'true' : 'false') }}">
        <div class="header__top">
            <div class="ps-container align-items-center">
                @if (is_plugin_active('ecommerce'))
                    <div class="header__left">
                        <div class="menu--product-categories">
                            <div class="menu__toggle"><i class="icon-menu"></i><span>
                                    {{ __('Shop by Department') }}</span></div>
                            <div class="menu__content" style="display: none">
                                <ul class="menu--dropdown">
                                    @php
                                        $categoriesDropdown = Theme::partial('product-categories-dropdown', [
                                            'categories' => ProductCategoryHelper::getProductCategoriesWithUrl(),
                                        ]);
                                    @endphp
                                    {!! $categoriesDropdown ?? null !!}
                                </ul>
                            </div>
                        </div>
                        <a class="ps-logo" href="{{ BaseHelper::getHomepageUrl() }}">
                            {!! Theme::getLogoImage(['style' => 'max-height: 40px']) !!}
                        </a>
                    </div>
                    <div class="header__center">
                        <form class="ps-form--quick-search" action="{{ route('public.products') }}"
                            data-ajax-url="{{ route('public.ajax.search-products') }}" method="get">
                            <div class="form-group--icon">
                                <div class="product-cat-label">{{ __('All') }}</div>
                                <select class="form-control product-category-select" name="categories[]">
                                    <option value="0">{{ __('All') }}</option>
                                    {!! ProductCategoryHelper::renderProductCategoriesSelect() !!}
                                </select>
                            </div>
                            <input class="form-control input-search-product" name="q" type="text"
                                placeholder="{{ __("I'm shopping for...") }}" autocomplete="off">
                            <div class="spinner-icon">
                                <i class="fa fa-spin fa-spinner"></i>
                            </div>
                            <button type="submit">{{ __('Search') }}</button>
                            <div class="ps-panel--search-result"></div>
                        </form>
                    </div>
                    <div class="header__right">
                        <div class="header__actions">
                            {!! apply_filters('before_theme_header_actions', null) !!}
                            @if (EcommerceHelper::isCompareEnabled())
                                <a class="header__extra btn-compare" href="{{ route('public.compare') }}"><i
                                        class="icon-chart-bars"></i><span><i>{{ Cart::instance('compare')->count() }}</i></span></a>
                            @endif
                            @if (EcommerceHelper::isWishlistEnabled())
                                <a class="header__extra btn-wishlist" href="{{ route('public.wishlist') }}"><i
                                        class="icon-heart"></i><span><i>{{ !auth('customer')->check() ? Cart::instance('wishlist')->count() : auth('customer')->user()->wishlist()->count() }}</i></span></a>
                            @endif
                            @if (EcommerceHelper::isCartEnabled())
                                <div class="ps-cart--mini">
                                    <a class="header__extra btn-shopping-cart" href="{{ route('public.cart') }}"><i
                                            class="icon-bag2"></i><span><i>{{ Cart::instance('cart')->count() }}</i></span></a>
                                    <div class="ps-cart--mobile">
                                        {!! Theme::partial('cart') !!}
                                    </div>
                                </div>
                            @endif
                            {!! apply_filters('after_theme_header_actions', null) !!}
                            <div class="ps-block--user-header">
                                <div class="ps-block__left"><i class="icon-user"></i></div>
                                <div class="ps-block__right">
                                    @if (auth('customer')->check())
                                        <a href="{{ route('customer.overview') }}"
                                            class="customer-name">{{ auth('customer')->user()->name }}</a>
                                        <a href="{{ route('customer.logout') }}">{{ __('Logout') }}</a>
                                    @else
                                        <a href="{{ route('customer.login') }}">{{ __('Login') }}</a><a
                                            href="{{ route('customer.register') }}">{{ __('Register') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <nav class="navigation">
            <div class="ps-container">
                <div class="navigation__left">
                    <div class="menu--product-categories">
                        <div class="menu__toggle"><i class="icon-menu"></i><span> {{ __('Shop by Department') }}</span>
                        </div>
                        <div class="menu__content" style="display: none">
                            <ul class="menu--dropdown">
                                {!! $categoriesDropdown ?? null !!}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="navigation__right">
                    {!! Menu::renderMenuLocation('main-menu', [
                        'view' => 'menu',
                        'options' => ['class' => 'menu'],
                    ]) !!}
                    @if (is_plugin_active('ecommerce'))
                        <ul class="navigation__extra">
                            @if (is_plugin_active('marketplace'))
                                {{-- <li>
                                    <a href="#" id="location-dropdown-toggle" class="location-dropdown">
                                        <i class="fas fa-map-marker-alt" style="color: white; margin-right: 8px;"></i>
                                        <span id="user-location">Detecting...</span>
                                        <i class="caret-down-icon"></i>
                                    </a>
                                    <!-- Dropdown Content -->
                                    <div id="location-dropdown" style="display: none;">
                                        <div id="dropdown-header">
                                            <p>Choose your location</p>
                                            <button id="close-dropdown">&times;</button>
                                        </div>
                                        <div id="dropdown-body">
                                            <ul id="city-list">
                                                @foreach (\App\Models\MpStore::getAllCitiesWithNames() as $store)
                                                    <li class="city-item">
                                                        <!-- Add inline style to make the text black -->
                                                        <a href="{{ $store->store_url }}" style="color: black;">
                                                            {{ strtoupper(trim($store->city)) }} - {{ $store->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>

                                        </div>
                                    </div>
                                </li> --}}
                                <li>
                                    <i class="fas fa-map-marker-alt" style="color: white; margin-right: 8px;"></i>
                                    <a href="#" style="color: white;">Bikaner
                                    </a>
                                </li>
                                <li><a
                                        href="{{ !auth('customer')->check() ? route('customer.register') : (auth('customer')->user()->is_vendor ? route('marketplace.vendor.dashboard') : route('marketplace.vendor.become-vendor')) }}">{{ theme_option('sell_on_site_text') ?: __('Sell On LocalKonnect') }}</a>
                                </li>
                            @endif
                            @if (EcommerceHelper::isOrderTrackingEnabled())
                                <li><a href="{{ route('public.orders.tracking') }}">{{ __('Track your order') }}</a>
                                </li>
                            @endif
                            @php $currencies = get_all_currencies(); @endphp
                            @if (count($currencies) > 1)
                                <li>
                                    <div class="ps-dropdown">
                                        <a
                                            href="{{ route('public.change-currency', get_application_currency()->title) }}"><span>{{ get_application_currency()->title }}</span></a>
                                        <ul class="ps-dropdown-menu">
                                            @foreach ($currencies as $currency)
                                                @if ($currency->id !== get_application_currency_id())
                                                    <li><a
                                                            href="{{ route('public.change-currency', $currency->title) }}"><span>{{ $currency->title }}</span></a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @endif
                            @if (is_plugin_active('language'))
                                {!! Theme::partial('language-switcher') !!}
                            @endif
                        </ul>
                    @endif
                </div>
            </div>
        </nav>
    </header>
    @if (Theme::get('headerMobile'))
        {!! Theme::get('headerMobile') !!}
    @else
        {!! Theme::partial('header-mobile') !!}
    @endif
    @if (is_plugin_active('ecommerce'))
        <div class="ps-panel--sidebar" id="cart-mobile" style="display: none">
            <div class="ps-panel__header">
                <h3>{{ __('Shopping Cart') }}</h3>
            </div>
            <div class="navigation__content">
                <div class="ps-cart--mobile">
                    {!! Theme::partial('cart') !!}
                </div>
            </div>
        </div>
        <div class="ps-panel--sidebar" id="navigation-mobile" style="display: none">
            <div class="ps-panel__header">
                <h3>{{ __('Categories') }}</h3>
            </div>
            <div class="ps-panel__content">
                <ul class="menu--mobile">
                    {!! $categoriesDropdown ?? null !!}
                </ul>
            </div>
        </div>
    @endif

    <div class="navigation--list">
        <div class="navigation__content">
            <a class="navigation__item ps-toggle--sidebar" href="#menu-mobile"><i class="icon-menu"></i><span>
                    {{ __('Menu') }}</span></a>
            <a class="navigation__item ps-toggle--sidebar" href="#navigation-mobile"><i class="icon-list4"></i><span>
                    {{ __('Categories') }}</span></a>
            <a class="navigation__item ps-toggle--sidebar" href="#search-sidebar"><i
                    class="icon-magnifier"></i><span> {{ __('Search') }}</span></a>
            <a class="navigation__item ps-toggle--sidebar" href="#cart-mobile"><i class="icon-bag2"></i><span>
                    {{ __('Cart') }}</span></a>
        </div>
    </div>

    @if (is_plugin_active('ecommerce'))
        <div class="ps-panel--sidebar" id="search-sidebar" style="display: none">
            <div class="ps-panel__header">
                <form class="ps-form--search-mobile" action="{{ route('public.products') }}"
                    data-ajax-url="{{ route('public.ajax.search-products') }}" method="get">
                    <div class="form-group--nest position-relative">
                        <input class="form-control input-search-product" name="q"
                            value="{{ BaseHelper::stringify(request()->query('q')) }}" type="text"
                            autocomplete="off" placeholder="{{ __('Search something...') }}">
                        <div class="spinner-icon">
                            <i class="fa fa-spin fa-spinner"></i>
                        </div>
                        <button type="submit"><i class="icon-magnifier"></i></button>
                        <div class="ps-panel--search-result"></div>
                    </div>
                </form>
            </div>
            <div class="navigation__content"></div>
        </div>
    @endif
    <div class="ps-panel--sidebar" id="menu-mobile" style="display: none">
        <div class="ps-panel__header">
            <h3>{{ __('Menu') }}</h3>
        </div>
        <div class="ps-panel__content">
            {!! Menu::renderMenuLocation('main-menu', [
                'view' => 'menu',
                'options' => ['class' => 'menu--mobile'],
            ]) !!}

            <ul class="menu--mobile menu--mobile-extra">
                @if (is_plugin_active('ecommerce'))
                    @if (EcommerceHelper::isOrderTrackingEnabled())
                        <li><a href="{{ route('public.orders.tracking') }}"><i class="icon-check-square"></i>
                                {{ __('Track your order') }}</a></li>
                    @endif
                    @if (EcommerceHelper::isCompareEnabled())
                        <li><a href="{{ route('public.compare') }}"><i class="icon-chart-bars"></i>
                                <span>{{ __('Compare') }}</span></a></li>
                    @endif
                    @if (EcommerceHelper::isWishlistEnabled())
                        <li><a href="{{ route('public.wishlist') }}"><i class="icon-heart"></i>
                                <span>{{ __('Wishlist') }}</span></a></li>
                    @endif
                    @if (count($currencies) > 1)
                        <li class="menu-item-has-children">
                            <a href="#"><span>{{ get_application_currency()->title }}</span></a>
                            <span class="sub-toggle"></span>
                            <ul class="sub-menu">
                                @foreach ($currencies as $currency)
                                    @if ($currency->id !== get_application_currency_id())
                                        <li><a
                                                href="{{ route('public.change-currency', $currency->title) }}"><span>{{ $currency->title }}</span></a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif

                @if (is_plugin_active('language'))
                    @php
                        $supportedLocales = Language::getSupportedLocales();
                    @endphp

                    @if ($supportedLocales && count($supportedLocales) > 1)
                        @php
                            $languageDisplay = setting('language_display', 'all');
                        @endphp
                        <li class="menu-item-has-children">
                            <a href="#">
                                @if ($languageDisplay == 'all' || $languageDisplay == 'flag')
                                    {!! language_flag(Language::getCurrentLocaleFlag(), Language::getCurrentLocaleName()) !!}
                                @endif
                                @if ($languageDisplay == 'all' || $languageDisplay == 'name')
                                    {{ Language::getCurrentLocaleName() }}
                                @endif
                            </a>
                            <span class="sub-toggle"></span>
                            <ul class="sub-menu">
                                @foreach ($supportedLocales as $localeCode => $properties)
                                    @if ($localeCode != Language::getCurrentLocale())
                                        <li>
                                            <a
                                                href="{{ Language::getSwitcherUrl($localeCode, $properties['lang_code']) }}">
                                                @if ($languageDisplay == 'all' || $languageDisplay == 'flag')
                                                    {!! language_flag($properties['lang_flag'], $properties['lang_name']) !!}
                                                @endif
                                                @if ($languageDisplay == 'all' || $languageDisplay == 'name')
                                                    <span>{{ $properties['lang_name'] }}</span>
                                                @endif
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>


    <!-- JavaScript -->
    <script>
        // Get references to elements
        const toggle = document.getElementById('location-dropdown-toggle');
        const dropdown = document.getElementById('location-dropdown');
        const closeBtn = document.getElementById('close-dropdown');
        const setLocationBtn = document.getElementById('set-location-btn');
        const locationInput = document.getElementById('location-input');
        const userLocation = document.getElementById('user-location');
        const cityItems = document.querySelectorAll('.city-item'); // Target all city list items

        // Toggle dropdown visibility
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        });

        // Close dropdown
        closeBtn.addEventListener('click', () => {
            dropdown.style.display = 'none';
        });

        // Set location when a city is clicked
        cityItems.forEach((city) => {
            city.addEventListener('click', () => {
                userLocation.textContent = city.textContent; // Update displayed location
                dropdown.style.display = 'none'; // Hide dropdown
            });
        });

        // Handle setting location
        setLocationBtn.addEventListener('click', () => {
            const location = locationInput.value.trim();
            if (location) {
                userLocation.textContent = location;
                dropdown.style.display = 'none';
            } else {
                alert('Please enter a location.');
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target) && !toggle.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>
