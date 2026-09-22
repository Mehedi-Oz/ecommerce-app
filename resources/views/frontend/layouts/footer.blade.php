    <footer class="footer">

        <div class="footer-top">
            <div class="container">
                <div class="inner-content">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="footer-logo">
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('assets/frontend/images/logo/white-logo.png') }}" alt="#">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 col-12">
                            <div class="store-footer-newsletter">
                                <h4 class="title">
                                    {{ __("Subscribe to our Newsletter") }}
                                    <span>{{ __("Get all the latest information, Sales and Offers.") }}</span>
                                </h4>
                                <div class="store-newsletter-form-head">
                                    <form action="#" method="get" target="_blank" class="store-newsletter-form">
                                        <input name="EMAIL" placeholder="{{ __("Email address here...") }}" type="email">
                                        <div class="button">
                                            <button class="btn">{{ __("Subscribe") }}<span class="dir-part"></span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="footer-middle">
            <div class="container">
                <div class="bottom-inner">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">

                            <div class="single-footer f-contact">
                                <h3>{{ __("Get In Touch With Us") }}</h3>
                                <p class="phone">{{ __("Phone: +1 (900) 33 169 7720") }}</p>
                                <ul>
                                    <li><span>{{ __("Monday-Friday:") }} </span> {{ __("9.00 am - 8.00 pm") }}</li>
                                    <li><span>{{ __("Saturday:") }} </span> {{ __("10.00 am - 6.00 pm") }}</li>
                                </ul>
                                <p class="mail">
                                    <a
                                        href="https://demo.graygrids.com/cdn-cgi/l/email-protection#5b282e2b2b34292f1b2833342b3c29323f2875383436"><span
                                            class="__cf_email__"
                                            data-cfemail="98ebede8e8f7eaecd8ebf0f7e8ffeaf1fcebb6fbf7f5">{{ __("[email&#160;protected]") }}</span></a>
                                </p>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-6 col-12">

                            <div class="single-footer our-app">
                                <h3>{{ __("Our Mobile App") }}</h3>
                                <ul class="app-btn">
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="lni lni-apple"></i>
                                            <span class="small-title">{{ __("Download on the") }}</span>
                                            <span class="big-title">{{ __("App Store") }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="lni lni-play-store"></i>
                                            <span class="small-title">{{ __("Download on the") }}</span>
                                            <span class="big-title">{{ __("Google Play") }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-6 col-12">

                            <div class="single-footer f-link">
                                <h3>{{ __("Information") }}</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">{{ __("About Us") }}</a></li>
                                    <li><a href="javascript:void(0)">{{ __("Contact Us") }}</a></li>
                                    <li><a href="javascript:void(0)">{{ __("Downloads") }}</a></li>
                                    <li><a href="javascript:void(0)">{{ __("Sitemap") }}</a></li>
                                    <li><a href="javascript:void(0)">{{ __("FAQs Page") }}</a></li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-6 col-12">

                            <div class="single-footer f-link">
                                <h3>{{ __("Shop Departments") }}</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">{{ __("Computers & Accessories") }}</a></li>
                                    <li><a href="javascript:void(0)">{{ __("Smartphones & Tablets") }}</a></li>
                                    <li><a href="javascript:void(0)">{{ __("TV, Video & Audio") }}</a></li>
                                    <li><a href="javascript:void(0)">{{ __("Cameras, Photo & Video") }}</a></li>
                                    <li><a href="javascript:void(0)">{{ __("Headphones") }}</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="footer-bottom">
            <div class="container">
                <div class="inner-content">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-12">
                            <div class="payment-gateway">
                                <span>{{ __("We Accept:") }}</span>
                                <img src="{{ asset('assets/frontend/images/footer/credit-cards-footer.png') }}" alt="#">
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="copyright">
                                <p>&copy; {{ date("Y") }} {{ config("app.name") }} by <a href="https://github.com/Mehedi-Oz"
                                        rel="nofollow" target="_blank">Hasan</a></p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <ul class="socila">
                                <li>
                                    <span>{{ __("Follow Us On:") }}</span>
                                </li>
                                <li><a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-instagram"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="lni lni-google"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </footer>
