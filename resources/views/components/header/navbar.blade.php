    <header>
        <!-- TOP-BAR -->
        {{-- <div class="top-bar bg-dark-2 @@display py-1 z-3">
            <div class="container custom-container d-flex flex-wrap justify-content-between align-items-center">
                <ul class="navbar-nav border-0 pe-0 flex-row gap-3">
                    <li class="nav-item dropdown">
                        <a class="nav-link fw-semibold fs-7 d-none d-md-block" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Indonesia
                            <i class="bi bi-chevron-down fs-7 ms-1"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-capitalize fs-7" href="#">Indonesia</a></li>
                            <li><a class="dropdown-item text-capitalize fs-7" href="#">English</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link fw-semibold fs-7 d-none d-md-block" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            IDR
                            <i class="bi bi-chevron-down fs-7 ms-1"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-capitalize fs-7" href="#">IDR</a></li>
                            <li><a class="dropdown-item text-capitalize fs-7" href="#">USD</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex justify-content-center gap-3 align-self-stretch">
                    <a href="#" class="fs-7 d-flex align-items-center px-3">
                        <i class="ri-mail-open-line text-white"></i>
                        <span class="text-secondary-2 border-opacity-10"> &nbsp; info@astrax.com </span>
                    </a>
                    <a href="telto:(123) 456 789 00" class="fs-7 d-flex align-items-center">
                        <i class="ri-phone-line text-white"></i>
                        <span class="text-secondary-2 border-opacity-10"> +(123) 456 789 00 </span>
                    </a>
                </div>
            </div>
        </div> --}}

        <nav class="navbar navbar-expand-lg @@classList navbar-page-9 z-3 p-0">
            <div class="container-fluid px-0 border-bottom">
                <a class="navbar-brand border-end py-4 pe-9 ps-4" href="/">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <g>
                            <path class="fill-primary" d="M24.5043 9.79724L22.7082 18.3981L35.2929 17.1948L37.1117 7.00605L24.5043 9.79724Z" />
                            <path class="fill-primary" d="M31.9171 17.6837L23.2697 20.6189L30.6333 30.3865L40.723 26.6545L31.9171 17.6837Z" />
                            <path class="fill-primary" d="M28.4204 27.86L21.4605 22.2312L16.332 33.3249L24.7296 39.7347L28.4204 27.86Z" />
                            <path class="fill-primary" d="M17.5913 29.998L19.1912 21.3633L6.63465 22.8288L5.04812 33.0511L17.5913 29.998Z" />
                            <path class="fill-primary" d="M10.2917 22.1777L18.8717 19.0632L11.2859 9.45346L1.28177 13.3945L10.2917 22.1777Z" />
                            <path class="fill-primary" d="M13.7243 12.2243L20.8121 17.7054L25.6875 6.50938L17.1442 0.277556L13.7243 12.2243Z" />
                        </g>
                    </svg>
                    <h5 class="mb-0 text-dark">Dizeners</h5>
                </a>
                <div class="d-none d-lg-flex me-auto ms-5 align-self-stretch">
                    <ul class="navbar-nav mx-auto gap-4 align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link text-uppercase" href="/">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase" href="about.html">Tentang</a>
                        </li>
                        <li class="nav-item dropdown menu-item-has-children">
                            <a class="nav-link text-uppercase" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Event </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item text-capitalize" href="schedule.html">Kategori</a></li>
                                <li><a class="dropdown-item text-capitalize" href="event-details.html">Pesanan</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase" href="contact.html">Kontak</a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex align-items-center align-self-stretch pe-4 pe-lg-0">
                    <a href="tel:+12345678900" class="d-none d-lg-flex py-4 px-6 border-start align-self-stretch align-items-center">
                        <span class="fs-7 fw-semibold text-dark">+(123) 456 789 00</span>
                    </a>
                    {{-- <a href="javascript:void(0)" class="d-none d-lg-flex py-4 px-6 border-start align-self-stretch align-items-center" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <g clip-path="url(#clip0_641_1352)">
                                <path d="M10.5656 3.40954C10.7453 3.58919 10.7453 3.88042 10.5656 4.06007C10.4757 4.15002 10.3581 4.19487 10.2404 4.19487C10.1226 4.19487 10.005 4.15002 9.91509 4.06007C8.30025 2.44546 5.67371 2.44546 4.0591 4.06007C3.87944 4.23973 3.58822 4.23973 3.40856 4.06007C3.2289 3.88042 3.2289 3.58919 3.40856 3.40954C5.38157 1.4363 8.59239 1.4363 10.5656 3.40954ZM19.8689 18.0296C19.8689 18.5212 19.6775 18.9833 19.3297 19.3307C18.9824 19.6785 18.5202 19.8699 18.0286 19.8699C17.5371 19.8699 17.0749 19.6785 16.7276 19.3307L11.8968 14.5C11.7172 14.3203 11.7172 14.0291 11.8968 13.8494L12.5474 13.1989L11.5272 12.1787C10.3126 13.2421 8.72443 13.889 6.98698 13.889C3.18174 13.889 0.0859375 10.7932 0.0859375 6.98796C0.0859375 3.18272 3.18174 0.0869141 6.98698 0.0869141C10.7922 0.0869141 13.888 3.18272 13.888 6.98796C13.888 8.72541 13.2412 10.3136 12.1777 11.5282L13.1979 12.5484L13.8485 11.8978C14.0281 11.7182 14.3193 11.7182 14.499 11.8978L19.3297 16.7285C19.6775 17.0759 19.8689 17.538 19.8689 18.0296ZM12.9679 6.98796C12.9679 3.69018 10.285 1.00705 6.98698 1.00705C3.68897 1.00705 1.00608 3.69018 1.00608 6.98796C1.00608 10.2857 3.68897 12.9689 6.98698 12.9689C10.285 12.9689 12.9679 10.2857 12.9679 6.98796ZM18.9488 18.0296C18.9488 17.7839 18.8531 17.553 18.6792 17.3791L14.1737 12.8736L12.8726 14.1747L17.3781 18.6802C17.7259 19.028 18.3316 19.028 18.6792 18.6802C18.8531 18.5063 18.9488 18.2753 18.9488 18.0296Z" fill="#24222C" />
                            </g>
                        </svg>
                    </a> --}}
                    <a href="javascript:void(0)" class="menu-tigger d-none d-lg-flex py-4 px-6 border-start align-self-stretch align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                            <rect width="3" height="3" fill="#24222C" />
                            <rect y="8" width="3" height="3" fill="#24222C" />
                            <rect y="16" width="3" height="3" fill="#24222C" />
                            <rect x="8" width="3" height="3" fill="#24222C" />
                            <rect x="8" y="8" width="3" height="3" fill="#24222C" />
                            <rect x="16" y="16" width="3" height="3" fill="#24222C" />
                            <rect x="16" width="3" height="3" fill="#24222C" />
                            <rect x="16" y="8" width="3" height="3" fill="#24222C" />
                        </svg>
                    </a>
                    <div class="burger-icon burger-icon-white border rounded-3 top-0 end-0">
                        <span class="burger-icon-top"></span>
                        <span class="burger-icon-mid"></span>
                        <span class="burger-icon-bottom"></span>
                    </div>
                </div>
            </div>
        </nav>
        <!-- offCanvas-menu -->
        <div class="offCanvas__info">
            <div class="offCanvas__close-icon menu-close">
                <button class="btn-close" aria-label="Close"><i class="ri-close-line"></i></button>
            </div>
            <div class="offCanvas__logo mb-30">
                <a class="d-flex align-items-center gap-2" href="index.html">
                    <svg class="fill-primary" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <path d="M24.5053 9.79627L22.7092 18.3971L35.2939 17.1938L37.1127 7.00508L24.5053 9.79627Z" fill="#1AAA59" />
                        <path d="M31.918 17.6827L23.2707 20.618L30.6343 30.3856L40.724 26.6535L31.918 17.6827Z" fill="#1AAA59" />
                        <path d="M28.4214 27.859L21.4615 22.2303L16.3329 33.3239L24.7306 39.7337L28.4214 27.859Z" fill="#1AAA59" />
                        <path d="M17.5922 29.997L19.1922 21.3623L6.63563 22.8278L5.0491 33.0501L17.5922 29.997Z" fill="#1AAA59" />
                        <path d="M10.2927 22.1767L18.8727 19.0623L11.2868 9.45248L1.28274 13.3935L10.2927 22.1767Z" fill="#1AAA59" />
                        <path d="M13.7252 12.2233L20.813 17.7044L25.6885 6.50841L17.1452 0.276579L13.7252 12.2233Z" fill="#1AAA59" />
                    </svg>
                    <h5 class="mb-0 text-dark">Dizeners</h5>
                </a>
            </div>
            <div class="offCanvas__side-info mb-30">
                <div class="contact-list mb-30">
                    <h4>Office Address</h4>
                    <p>
                        Jalan Trans Sulawesi, Pentadu, Kecamatan Paguat, Pohuwato <br /> Provinsi Gorontalo
                    </p>
                </div>
                <div class="contact-list mb-30">
                    <h4>Phone Number</h4>
                    <p>+0989 7876 9865 9</p>
                    <p>+(090) 8765 86543 85</p>
                </div>
                <div class="contact-list mb-30">
                    <h4>Email Address</h4>
                    <p>hello@dizeners.com</p>
                    <p>support@dizeners.com</p>
                </div>
            </div>
            <div class="offCanvas__social-icon mt-30">
                <a href="javascript:void(0)"><i class="bi bi-facebook"></i></a>
                <a href="javascript:void(0)"><i class="bi bi-twitter-x"></i></a>
                <a href="javascript:void(0)"><i class="bi bi-linkedin"></i></a>
                <a href="javascript:void(0)"><i class="bi bi-behance"></i></a>
            </div>
        </div>
        <div class="offCanvas__overly"></div>
        <!-- Offcanvas search -->
        <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop">
            <div class="offcanvas-header">
                <button class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="container">
                    <div class="row">
                        <div class="col-8 mx-auto">
                            <h3 class="mb-4">Anda cari apa?</h3>
                            <form class="input-group mb-3" data-aos="zoom-in">
                                <input type="text" class="form-control" placeholder="Enter Your Keywords" aria-label="Enter Your Keywords" aria-describedby="button-addon2" />
                                <button class="btn btn-primary rounded-end-2" type="submit" aria-label="search" id="button-addon2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M19.25 19.25L15.5 15.5M4.75 11C4.75 7.54822 7.54822 4.75 11 4.75C14.4518 4.75 17.25 7.54822 17.25 11C17.25 14.4518 14.4518 17.25 11 17.25C7.54822 17.25 4.75 14.4518 4.75 11Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Offcanvas search -->
        <div class="mobile-menu-overlay"></div>
        <div class="mobile-header-active mobile-header-wrapper-style">
            <div class="mobile-header-wrapper-inner">
                <div class="mobile-header-logo">
                    <a class="d-flex align-items-center gap-2" href="index.html">
                        <svg class="fill-primary" xmlns="http://www.w3.org/2000/svg" width="35" height="40" viewBox="0 0 35 40" fill="none">
                            <g clip-path="url(#clip0_349_1513)">
                                <path d="M3.3335 31.9045V11.9335L17.4985 3.8395L31.667 11.9335V28.065L17.4985 36.1605L10 31.875V15.802L17.4985 11.517L25 15.802V24.196L17.4985 28.4815L16.667 28.0065V19.6715L20.858 17.2755L17.4985 15.3565L13.3335 17.738V29.94L17.4985 32.321L28.3335 26.1295V13.8685L17.4985 7.679L6.667 13.8685V33.8085L17.4985 40L35 30V10L17.4985 0L0 10V30L3.3335 31.9045Z" fill="#794AFF" />
                            </g>
                        </svg>
                        <h5 class="mb-0">Dizeners</h5>
                    </a>
                    <div class="burger-icon burger-icon-white border rounded-circle">
                        <span class="burger-icon-top"></span>
                        <span class="burger-icon-mid"></span>
                        <span class="burger-icon-bottom"></span>
                    </div>
                </div>
                <div class="mobile-header-content-area">
                    <div class="perfect-scroll">
                        <div class="mobile-menu-wrap mobile-header-border">
                            <nav>
                                <ul class="mobile-menu ps-0">
                                    <li>
                                        <a href="index.html">Homepages</a>
                                    </li>
                                    <li>
                                        <a href="about.html">About us</a>
                                    </li>
                                    <li class="has-children">
                                        <a href="#">Schedule</a>
                                        <ul class="sub-menu">
                                            <li><a href="schedule.html">Schedule</a></li>
                                            <li><a href="event-details.html">Event Details</a></li>
                                        </ul>
                                    </li>
                                    <li class="has-children">
                                        <a href="#">Pages</a>
                                        <ul class="sub-menu">
                                            <li><a href="speakers.html">Speakers</a></li>
                                            <li><a href="ticket.html">Buy tickets</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="contact.html">Contact</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="tgmobile__menu-bottom mt-auto">
                    <div class="contact-info">
                        <ul class="list-wrap">
                            <li><span class="opacity-50">Mail:</span> <a href="mailto:info@valom.com">info@dizeners.com</a></li>
                            <li><span class="opacity-50">Phone:</span> <a href="tel:0123456789">+123 888 9999</a></li>
                        </ul>
                    </div>
                    <div class="social-links">
                        <div class="social-icons gap-4 mt-4">
                            <a href="#" class="border border-opacity-10 border-white icon-shape icon-md">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="border border-opacity-10 border-white icon-shape icon-md">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="#" class="border border-opacity-10 border-white icon-shape icon-md">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="#" class="border border-opacity-10 border-white icon-shape icon-md">
                                <i class="bi bi-behance"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>