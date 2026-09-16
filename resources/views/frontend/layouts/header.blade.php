    <header class="header navbar-area">

        <div class="topbar">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-left">
                            <ul class="menu-top-link">
                                <li>
                                    <div class="select-position">
                                        <select id="select4">
                                            <option value="0" selected>{{ __("$ USD") }}</option>
                                            <option value="1">{{ __("€ EURO") }}</option>
                                            <option value="2">{{ __("$ CAD") }}</option>
                                            <option value="3">{{ __("₹ INR") }}</option>
                                            <option value="4">{{ __("¥ CNY") }}</option>
                                            <option value="5">{{ __("৳ BDT") }}</option>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="select-position">
                                        <select id="select5">
                                            <option value="0" selected>{{ __("English") }}</option>
                                            <option value="1">{{ __("Español") }}</option>
                                            <option value="2">{{ __("Filipino") }}</option>
                                            <option value="3">{{ __("Français") }}</option>
                                            <option value="4">{{ __("العربية") }}</option>
                                            <option value="5">{{ __("हिन्दी") }}</option>
                                            <option value="6">{{ __("বাংলা") }}</option>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-middle">
                            <ul class="useful-links">
                                <li><a href="{{ route('home') }}">{{ __("Home") }}</a></li>
                                <li><a href="about-us.html">{{ __("About Us") }}</a></li>
                                <li><a href="contact.html">{{ __("Contact Us") }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-end">
                            <div class="user">
                                <i class="lni lni-user"></i>
                                {{ __("Hello") }}
                            </div>
                            <ul class="user-login">
                                <li>
                                    <a href="login.html">{{ __("Sign In") }}</a>
                                </li>
                                <li>
                                    <a href="register.html">{{ __("Register") }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="header-middle">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-7">

                        <a class="navbar-brand" href="{{ route('home') }}">
                            <img src="{{ asset('assets/frontend/images/logo/logo.svg') }}" alt="{{ __("Logo") }}">
                        </a>

                    </div>
                    <div class="col-lg-5 col-md-7 d-xs-none">

                        <div class="main-menu-search">

                            <div class="navbar-search search-style-5">
                                <div class="search-select">
                                    <div class="select-position">
                                        <select id="select1">
                                            <option selected>{{ __('All') }}</option>
                                            @foreach ($navCategories as $navCategory)
                                                <option value="{{ $navCategory->id }}">{{ $navCategory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="search-input">
                                    <input type="text" placeholder="{{ __("Search") }}">
                                </div>
                                <div class="search-btn">
                                    <button><i class="lni lni-search-alt"></i></button>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-lg-4 col-md-2 col-5">
                        <div class="middle-right-area">
                            <div class="nav-hotline">
                                <i class="lni lni-phone"></i>
                                <h3>{{ __("Hotline:") }}
                                    <span>{{ __("(+100) 123 456 7890") }}</span>
                                </h3>
                            </div>
                            <div class="navbar-cart">
                                <div class="wishlist">
                                    <a href="javascript:void(0)">
                                        <i class="lni lni-heart"></i>
                                        <span class="total-items">{{ __("0") }}</span>
                                    </a>
                                </div>
                                <div class="cart-items">
                                    <a href="javascript:void(0)" class="main-btn">
                                        <i class="lni lni-cart"></i>
                                        <span class="total-items">{{ __("2") }}</span>
                                    </a>

                                    <div class="shopping-item">
                                        <div class="dropdown-cart-header">
                                            <span>{{ __("2 Items") }}</span>
                                            <a href="{{ route('cart.show') }}">{{ __("View Cart") }}</a>
                                        </div>
                                        <ul class="shopping-list">
                                            <li>
                                                <a href="javascript:void(0)" class="remove"
                                                    title="{{ __("Remove this item") }}"><i class="lni lni-close"></i></a>
                                                <div class="cart-img-head">
                                                    <a class="cart-img" href="{{ route('product-details') }}"><img
                                                            src="{{ asset('assets/frontend/images/header/cart-items/item1.jpg') }}"
                                                            alt="#"></a>
                                                </div>
                                                <div class="content">
                                                    <h4><a href="{{ route('product-details') }}">
                                                            {{ __("Apple Watch Series 6") }}</a></h4>
                                                    <p class="quantity">{{ __("1x -") }} <span class="amount">{{ __("$99.00") }}</span></p>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="remove"
                                                    title="{{ __("Remove this item") }}"><i class="lni lni-close"></i></a>
                                                <div class="cart-img-head">
                                                    <a class="cart-img" href="{{ route('product-details') }}"><img
                                                            src="{{ asset('assets/frontend/images/header/cart-items/item2.jpg') }}"
                                                            alt="#"></a>
                                                </div>
                                                <div class="content">
                                                    <h4><a href="{{ route('product-details') }}">{{ __("Wi-Fi Smart Camera") }}</a></h4>
                                                    <p class="quantity">{{ __("1x -") }} <span class="amount">{{ __("$35.00") }}</span></p>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="bottom">
                                            <div class="total">
                                                <span>{{ __("Total") }}</span>
                                                <span class="total-amount">{{ __("$134.00") }}</span>
                                            </div>
                                            <div class="button">
                                                <a href="{{ route('checkout') }}" class="btn animate">{{ __("Checkout") }}</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="nav-inner">

                        <div class="mega-category-menu">
                            <span class="cat-button"><i class="lni lni-menu"></i>{{ __("All Categories") }}</span>
                            <ul class="sub-category">
                                @forelse ($navCategories as $navCategory)
                                    <li><a href="{{ route('product-category', ['category' => $navCategory->id]) }}">{{ $navCategory->name }}
                                            @if ($navCategory->subCategories->isNotEmpty())
                                                <i class="lni lni-chevron-right"></i>
                                            @endif
                                        </a>
                                        @if ($navCategory->subCategories->isNotEmpty())
                                            <ul class="inner-sub-category">
                                                @foreach ($navCategory->subCategories as $navSubCategory)
                                                    <li><a href="{{ route('product-category', ['category' => $navCategory->id, 'subcategory' => $navSubCategory->id]) }}">{{ $navSubCategory->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @empty
                                    <li><a href="{{ route('product-category') }}">{{ __('No categories available') }}</a></li>
                                @endforelse
                            </ul>
                        </div>


                        <nav class="navbar navbar-expand-lg">
                            <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="{{ __("Toggle navigation") }}">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a href="{{ route('home') }}" class="active" aria-label="{{ __("Toggle navigation") }}">{{ __("Home") }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dd-menu collapsed" href="javascript:void(0)"
                                            data-bs-toggle="collapse" data-bs-target="#submenu-1-2"
                                            aria-controls="navbarSupportedContent" aria-expanded="false"
                                            aria-label="{{ __("Toggle navigation") }}">{{ __("Pages") }}</a>
                                        <ul class="sub-menu collapse" id="submenu-1-2">
                                            <li class="nav-item"><a href="about-us.html">{{ __("About Us") }}</a></li>
                                            <li class="nav-item"><a href="faq.html">{{ __("Faq") }}</a></li>
                                            <li class="nav-item"><a href="login.html">{{ __("Login") }}</a></li>
                                            <li class="nav-item"><a href="register.html">{{ __("Register") }}</a></li>
                                            <li class="nav-item"><a href="mail-success.html">{{ __("Mail Success") }}</a></li>
                                            <li class="nav-item"><a href="404.html">{{ __("404 Error") }}</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dd-menu collapsed" href="javascript:void(0)"
                                            data-bs-toggle="collapse" data-bs-target="#submenu-1-3"
                                            aria-controls="navbarSupportedContent" aria-expanded="false"
                                            aria-label="{{ __("Toggle navigation") }}">{{ __("Shop") }}</a>
                                        <ul class="sub-menu collapse" id="submenu-1-3">
                                            <li class="nav-item"><a href="{{ route('product-category') }}">{{ __("Shop Grid") }}</a></li>
                                            <li class="nav-item"><a href="product-list.html">{{ __("Shop List") }}</a></li>
                                            <li class="nav-item"><a href="{{ route('product-details') }}">{{ __("shop Single") }}</a></li>
                                            <li class="nav-item"><a href="{{ route('cart.show') }}">{{ __("Cart") }}</a></li>
                                            <li class="nav-item"><a href="{{ route('checkout') }}">{{ __("Checkout") }}</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dd-menu collapsed" href="javascript:void(0)"
                                            data-bs-toggle="collapse" data-bs-target="#submenu-1-4"
                                            aria-controls="navbarSupportedContent" aria-expanded="false"
                                            aria-label="{{ __("Toggle navigation") }}">{{ __("Blog") }}</a>
                                        <ul class="sub-menu collapse" id="submenu-1-4">
                                            <li class="nav-item"><a href="blog-grid-sidebar.html">{{ __("Blog Grid
                                                    Sidebar") }}</a>
                                            </li>
                                            <li class="nav-item"><a href="blog-single.html">{{ __("Blog Single") }}</a></li>
                                            <li class="nav-item"><a href="blog-single-sidebar.html">{{ __("Blog Single
                                                    Sibebar") }}</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="contact.html" aria-label="{{ __("Toggle navigation") }}">{{ __("Contact Us") }}</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">

                    <div class="nav-social">
                        <h5 class="title">{{ __("Follow Us:") }}</h5>
                        <ul>
                            <li>
                                <a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><i class="lni lni-instagram"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"><i class="lni lni-skype"></i></a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

    </header>
