<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="SANCON 2025, ASPA 2025, ASPACON 2025" />
    <meta name="rights" content="© Copyright 2024 Society of Anesthesiologists of Nepal" />
    <meta name="description"
        content="International Conference of Society of Anesthesiologists of Nepal 2025 Collaboration with Asian Society of Paediatric Anesthesiologists" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend') }}/assets/images/logo/SAN.png">
    <title> SANCON 2025 | ASPA 2025 | International Conference of Society of Anesthesiologists of Nepal 2025</title>
    <link rel="stylesheet preload" href="{{ asset('frontend') }}/assets/css/plugins/swiper.min.css" as="style">
    <link rel="stylesheet preload" href="{{ asset('frontend') }}/assets/css/plugins/magnific-popup.css" as="style">
    <link rel="stylesheet preload" href="{{ asset('frontend') }}/assets/css/plugins/metismenu.css" as="style">
    <link rel="stylesheet preload" href="{{ asset('frontend') }}/assets/css/vendor/bootstrap.min.css" as="style">
    <link rel="stylesheet preload" href="{{ asset('frontend') }}/assets/css/plugins/fontawesome.min.css" as="style">
    <link rel="stylesheet preload" href="{{ asset('frontend') }}/assets/css/style.css" as="style">
    <!-- jQuery (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>

    <header class="header-two header--sticky">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-two-content-main">
                        <a href="{{ route('front.index') }}" class="logo-area">
                            <a href="{{ route('front.index') }}" class="logo-area">
                                SANCON - ASPA 2025

                            </a>

                        </a>
                        <nav class="main-nav-area">
                            <ul class="list-unstyled fluxi-desktop-menu">
                                <li class="menu-item"><a class="main-element fluxi-dropdown-main-element"
                                        href="{{ route('front.index') }}">Home</a></li>
                                <li class="menu-item fluxi-has-dropdown">
                                    <a href="#" class="fluxi-dropdown-main-element">About Conference</a>
                                    <ul class="fluxi-submenu list-unstyled menu-home">
                                        <li class="nav-item"><a class="nav-link page" href="#">About SANCON ASPA
                                                2025</a></li>

                                        <li class="nav-item sub-dropdown">
                                            <a href="#" class="nav-link sub-menu-link">Committees</a>
                                            <ul class="fluxi-submenu third-lvl base">
                                                @foreach ($committeesAll as $committeeAll)
                                                    <li><a class="mobile-menu-link"
                                                            href="{{ route('front.committee', $committeeAll->slug) }}">{{ $committeeAll->committee_name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('front.message') }}">Messages</a></li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('front.abstractGuidelines') }}">Abstract Guidelines</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="{{ route('front.accommodation') }}">Travel and Accommodation</a>
                                        </li>
                                        @foreach ($downloadsAll->where('id',3) as $downloadAll)
                                            <li class="nav-item"><a class="nav-link" href="{{ asset('storage/downloads/' . $downloadAll->file) }}"
                                                    target="_blank">{{ $downloadAll->title }}</a></li>
                                        @endforeach
                            
                                    </ul>
                                </li>
                                <li class="menu-item"><a class="main-element fluxi-dropdown-main-element"
                                        href="{{ route('front.speakers') }}">Speakers</a></li>
                                <li class="menu-item"><a class="main-element fluxi-dropdown-main-element"
                                        href="{{ route('front.scientificSession') }}">Scientific Program</a></li>
                                <li class="menu-item fluxi-has-dropdown">
                                    <a href="#" class="fluxi-dropdown-main-element">Workshops</a>
                                    <ul class="fluxi-submenu list-unstyled menu-home">
                                        @foreach ($workshopsAll as $w_item)
                                            <li class="nav-item"><a class="nav-link page"
                                                    href="{{ route('front.workshopDetail', $w_item->slug) }}">{{ $w_item->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <!-- End Dropdown Menu -->
                                </li>
                                <li class="menu-item"><a class="main-element fluxi-dropdown-main-element"
                                        href="{{ route('front.notice') }}">News & Notice</a></li>

                            </ul>
                        </nav>
                        <div class="header-end-area">
                            <ul>
                                @php
                                    $isIndex = session('isIndex');
                                @endphp
                                @if ($isIndex)
                                    <li><a href="#signUpSection" id="registerLink">Register</a></li>
                                @else
                                    <li><a href="{{ route('front.index') }}#signUpSection">Register</a></li>
                                @endif
                                <li><a href="{{ route('login') }}">Sign In</a></li>
                            </ul>
                            <div class="menu-btn" id="menu-btn">

                                <svg width="20" height="16" viewBox="0 0 20 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect y="14" width="20" height="2" fill="#1F1F25"></rect>
                                    <rect y="7" width="20" height="2" fill="#1F1F25"></rect>
                                    <rect width="20" height="2" fill="#1F1F25"></rect>
                                </svg>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <div class="rts-footer-area footer-five" style="padding-top:80px; padding-bottom:60px;">
        <div class="container mb--65">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <!-- single footer four wized -->
                    <div class="single-footer-four-wized">
                        <h5 class="title">SANCON - ASPA 2025</h5>
                        <ul>
                            <li><a href="#">About Conference</a></li>
                            <li><a href="{{ route('front.message') }}">Message</a></li>
                            <li><a href="{{ route('front.speakers') }}">Speakers</a></li>
                            <li><a href="#">Scientific Program</a></li>


                        </ul>
                    </div>
                    <!-- single footer four wized end -->
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <!-- single footer four wized -->
                    <div class="single-footer-four-wized">
                        <h5 class="title">Committee</h5>
                        <ul>
                            @foreach ($committeesAll as $committeeAll)
                                <li><a
                                        href="{{ route('front.committee', $committeeAll->slug) }}">{{ $committeeAll->committee_name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- single footer four wized end -->
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <!-- single footer four wized -->
                    <div class="single-footer-four-wized">
                        <h5 class="title">Workshops</h5>
                        <ul>
                            @foreach ($workshopsAll as $workshopAll)
                                <li><a
                                        href="{{ route('front.workshopDetail', $workshopAll->slug) }}">{{ $workshopAll->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>

                <div class="col-lg-3 col-md-4 col-sm-12">
                    <!-- single footer four wized -->
                    <div class="single-footer-four-wized">
                        <h5 class="title">Downloads</h5>
                        <ul>
                            @foreach ($downloadsAll as $downloadAll)
                                <li><a href="{{ asset('storage/downloads/' . $downloadAll->file) }}"
                                        target="_blank">{{ $downloadAll->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                </div>


            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright-area-four pt--65 mt-65 border-top">

                        <p>© {{ date('Y') }} SANCON - ASPA 2025, All Right Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="anywhere-home" class="">
    </div>


    <!-- side bar area  -->
    <div id="side-bar" class="side-bar header-two">
        <button class="close-icon-menu"><i class="fa-sharp fa-thin fa-xmark"></i></button>
        <!-- mobile menu area start -->
        <div class="mobile-menu-main">
            <nav class="nav-main mainmenu-nav mt--30">
                <ul class="mainmenu metismenu" id="mobile-menu-active">
                    <li><a href="{{ route('front.index') }}" class="main">Home</a></li>
                    <li class="has-droupdown">
                        <a href="#" class="main">About SANCON -ASPA 2025</a>
                        <ul class="submenu mm-collapse">
                            <li><a class="mobile-menu-link" href="#">About Conference</a></li>
                            <li class="has-droupdown third-lvl">
                                <a class="main" href="#">Committees</a>
                                <ul class="submenu-third-lvl mm-collapse">
                                    @foreach ($committeesAll as $committeeAll)
                                        <li><a
                                                href="{{ route('front.committee', $committeeAll->slug) }}"></a>{{ $committeeAll->committee_name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a class="mobile-menu-link" href="{{ route('front.abstractGuidelines') }}"
                                    target="_blank">Abstract Guidelines</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('front.speakers') }}" class="main">Speakers</a></li>
                    <li><a href="{{ route('front.scientificSession') }}" class="main">Scientific Program</a></li>
                    <li><a href="{{ route('front.notice') }}" class="main">News & Notice</a></li>
                    <li><a href="#" class="main">Contact Us</a></li>
                </ul>
            </nav>

            <ul class="social-area-one pl--20 mt--100">
                <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
            </ul>
        </div>
        <!-- mobile menu area end -->
    </div>
    <!-- side abr area end -->

    <!-- pre loader start -->
    <div class="loader-wrapper">
        <div class="loader">
        </div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- pre loader end -->

    <!-- THEME MODE SWITCHER -->
    <div class="rts-switcher rts-theme-mode">
        <div class="rts-darkmode">
            <a id="rts-data-toggle" class="rts-dark-light">
                <i class="rts-go-dark fal fa-moon"></i>
                <i class="rts-go-light fa-light fa-sun-bright"></i>
            </a>
        </div>
    </div>
    <!-- THEME MODE SWITCHER END -->

    <!-- progress area start -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
            </path>
        </svg>
    </div>
    <!-- progress area end -->



    <!-- jquery js -->
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/jquery.min.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/bootstrap.min.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/metismenu.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/vendor/jqueryui.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/vendor/waypoint.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/swiper.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/theia-sticky-sidebar.min.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/gsap.min.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/scrolltigger.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/vendor/split-text.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/vendor/split-type.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/vendor/waw.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/counter-up.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/magnific-popup.js"></script>
    <!-- contact form js -->
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/contact-form.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/main.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/plugins/toastr.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/scripts/toastr.script.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#registerLink, #registerLink2').click(function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $('#signUpSection').offset().top
                }, 800);
            });
        });
    </script>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error("{{ $error }}");
            </script>
        @endforeach
    @endif

    @yield('scripts')
</body>

</html>
