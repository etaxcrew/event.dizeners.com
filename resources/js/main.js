(function ($) {
    'use strict';
    /*=============================================
    =              Preloader       =
    =============================================*/
    function preloader() {
        $('#preloader').fadeOut();
    }
    /*=============================================
    =     Offcanvas Menu      =
    =============================================*/
    function offcanvasMenu() {
        $('.menu-tigger').on('click', function () {
            $('.offCanvas__info, .offCanvas__overly').addClass('active');
            return false;
        });
        $('.menu-close, .offCanvas__overly').on('click', function () {
            $('.offCanvas__info, .offCanvas__overly').removeClass('active');
        });
    }
    /*=============================================
    =          Data Background      =
    =============================================*/
    function dataBackground() {
        $('[data-background]').each(function () {
            $(this).css('background-image', 'url(' + $(this).attr('data-background') + ')');
        });
    }
    /*=============================================
    =           Go to top       =
    =============================================*/
    function progressPageLoad() {
        var progressWrap = document.querySelector('.btn-scroll-top');
        if (progressWrap != null) {
            var progressPath = document.querySelector('.btn-scroll-top path');
            var pathLength = progressPath.getTotalLength();
            var offset = 50;
            progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
            progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
            progressPath.style.strokeDashoffset = pathLength;
            progressPath.getBoundingClientRect();
            progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
            window.addEventListener('scroll', function (event) {
                var scroll = document.body.scrollTop || document.documentElement.scrollTop;
                var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                var progress = pathLength - (scroll * pathLength) / height;
                progressPath.style.strokeDashoffset = progress;
                var scrollElementPos = document.body.scrollTop || document.documentElement.scrollTop;
                if (scrollElementPos >= offset) {
                    progressWrap.classList.add('active-progress');
                } else {
                    progressWrap.classList.remove('active-progress');
                }
            });
            progressWrap.addEventListener('click', function (e) {
                e.preventDefault();
                window.scroll({
                    top: 0,
                    left: 0,
                    behavior: 'smooth',
                });
            });
        }
    }
    /*=============================================
    =           Aos Active       =
    =============================================*/
    function aosAnimation() {
        AOS.init({
            duration: 1000,
            mirror: true,
            once: true,
            disable: 'mobile',
        });
    }
    /*=============================================
    =           counterState       =
    =============================================*/
    function counterState() {
        var counters = document.querySelectorAll('.counter');
        counters.forEach(function (counter) {
            var countTo = counter.getAttribute('data-count');
            var countNum = parseInt(counter.textContent);
            var duration = 4000;
            var stepDuration = duration / Math.abs(countTo - countNum);
            var increment = countTo > countNum ? 1 : -1;
            var timer = setInterval(function () {
                countNum += increment;
                counter.textContent = countNum;
                if (countNum == countTo) {
                    clearInterval(timer);
                    //alert('finished');
                }
            }, stepDuration);
        });
    }
    /*=============================================
    =           Masonary Active       =
    =============================================*/
    function masonryFillter() {
        $('.masonary-active').imagesLoaded(function () {
            var $filter = '.masonary-active',
                $filterItem = '.filter-item',
                $filterMenu = '.filter-menu-active';
            if ($($filter).length > 0) {
                var $grid = $($filter).isotope({
                    itemSelector: $filterItem,
                    filter: '*',
                    masonry: {
                        // use outer width of grid-sizer for columnWidth
                        // columnWidth: 1,
                        columnWidth: '.grid-sizer',
                    },
                });
                // filter items on button click
                $($filterMenu).on('click', 'button', function () {
                    var filterValue = $(this).attr('data-filter');
                    $grid.isotope({
                        filter: filterValue,
                    });
                });
                // Menu Active Class
                $($filterMenu).on('click', 'button', function (event) {
                    event.preventDefault();
                    $(this).addClass('active');
                    $(this).siblings('.active').removeClass('active');
                });
            }
        });
    }
    function odometerCounter() {
        if ($('.odometer').length > 0) {
            $('.odometer').appear(function (e) {
                var odo = $('.odometer');
                odo.each(function () {
                    var countNumber = $(this).attr('data-count');
                    $(this).html(countNumber);
                });
            });
        }
    }
    function mobileHeaderActive() {
        var navbarTrigger = $('.burger-icon'),
            navCanvas = $('.burger-icon-2'),
            closeCanvas = $('.close-canvas'),
            endTrigger = $('.mobile-menu-close'),
            container = $('.mobile-header-active'),
            containerCanvas = $('.sidebar-canvas-wrapper'),
            wrapper4 = $('body');
        wrapper4.prepend('<div class="body-overlay-1"></div>');
        navbarTrigger.on('click', function (e) {
            navbarTrigger.toggleClass('burger-close');
            e.preventDefault();
            container.toggleClass('sidebar-visible');
            wrapper4.toggleClass('mobile-menu-active');
        });
        endTrigger.on('click', function () {
            container.removeClass('sidebar-visible');
            wrapper4.removeClass('mobile-menu-active');
        });
        var $offCanvasNav = $('.mobile-menu'),
            $offCanvasNavSubMenu = $offCanvasNav.find('.sub-menu');
        /*Add Toggle Button With Off Canvas Sub Menu*/
        $offCanvasNavSubMenu.parent().prepend('<span class="menu-expand"><i class="arrow-small-down"></i></span>');
        /*Close Off Canvas Sub Menu*/
        $offCanvasNavSubMenu.slideUp();
        /*Category Sub Menu Toggle*/
        $offCanvasNav.on('click', 'li a, li .menu-expand', function (e) {
            var $this = $(this);
            if (
                $this
                    .parent()
                    .attr('class')
                    .match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/) &&
                ($this.attr('href') === '#' || $this.hasClass('menu-expand'))
            ) {
                e.preventDefault();
                if ($this.siblings('ul:visible').length) {
                    $this.parent('li').removeClass('active');
                    $this.siblings('ul').slideUp();
                } else {
                    $this.parent('li').addClass('active');
                    $this.closest('li').siblings('li').removeClass('active').find('li').removeClass('active');
                    $this.closest('li').siblings('li').find('ul:visible').slideUp();
                    $this.siblings('ul').slideDown();
                }
            }
        });
    }
    /*=============================================
    =    		Magnific Popup		      =
    =============================================*/
    function magnificPopup() {
        $('.popup-image').magnificPopup({
            type: 'image',
            mainClass: 'mfp-with-zoom',
            gallery: {
                enabled: true,
            },
        });
        /* magnificPopup video view */
        $('.popup-video').magnificPopup({
            type: 'iframe',
            mainClass: 'mfp-with-zoom',
            zoom: {
                enabled: true,
                duration: 300,
                easing: 'ease-in-out',
                opener: function (openerElement) {
                    return openerElement.is('img') ? openerElement : openerElement.find('img');
                },
            },
        });
    }
    /*=============================================
    =    		 Wow Active  	         =
    =============================================*/
    function wowAnimation() {
        var wow = new WOW({
            boxClass: 'wow',
            animateClass: 'animated',
            offset: 0,
            mobile: false,
            live: true,
        });
        wow.init();
    }

    function customSwiper() {
        const slider6 = new Swiper('.slider-6', {
            slidesPerView: 5,
            spaceBetween: 10,
            slidesPerGroup: 1,
            centeredSlides: false,
            loop: true,
            autoplay: {
                delay: 4000,
            },
            breakpoints: {
                1200: {
                    slidesPerView: 5,
                    spaceBetween: 10,
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                576: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                0: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            on: {
                afterInit: function () {
                    // set padding left slide
                    var leftPadding = 0;
                    var swipperRoot = $('.swipper-root');
                    if (swipperRoot.length > 0) {
                        leftPadding = swipperRoot.offset().left;
                    }
                    if ($('.box-swiper-padding').length > 0) {
                        $('.box-swiper-padding').css('padding-left', leftPadding + 'px');
                    }
                },
            },
        });
    }
    /*=============================================
    =    		Carousel Ticker		      =
    =============================================*/
    function carauselScroll() {
        $('.carouselTicker-left').each(function () {
            $(this).carouselTicker({
                direction: 'prev',
                speed: 1,
                delay: 30,
            });
        });
        $('.carouselTicker-right').each(function () {
            $(this).carouselTicker({
                direction: 'next',
                speed: 1,
                delay: 30,
            });
        });
    }
    function cardScroll() {
        const cardsContainer = document.querySelector('.cards');
        if (!cardsContainer) {
            return;
        }
        const { ScrollObserver, valueAtPercentage } = aat;
        const cards = document.querySelectorAll('.card-custom');
        cardsContainer.style.setProperty('--cards-count', cards.length);
        cardsContainer.style.setProperty('--card-height', `${cards[0].clientHeight}px`);
        Array.from(cards).forEach((card, index) => {
            const offsetTop = 20 + index * 20;
            card.style.paddingTop = `${offsetTop}px`;
            if (index === cards.length - 1) {
                return;
            }
            const toScale = 1 - (cards.length - 1 - index) * 0.1;
            const nextCard = cards[index + 1];
            const cardInner = card.querySelector('.card__inner');
            ScrollObserver.Element(nextCard, {
                offsetTop,
                offsetBottom: window.innerHeight - card.clientHeight,
            }).onScroll(({ percentageY }) => {
                cardInner.style.scale = valueAtPercentage({
                    from: 1,
                    to: toScale,
                    percentage: percentageY,
                });
                cardInner.style.filter = `brightness(${valueAtPercentage({
                    from: 1,
                    to: 0.6,
                    percentage: percentageY,
                })})`;
            });
        });
    }
    function accordion() {
        window.setTimeout(function () {
            $('.accordion').css('opacity', '1');
        }, 2000);
        $('.accordion-item').addClass('default');
        $('.accordion-item').on('click', function () {
            var e = $('.accordion > .accordion-item');
            if (e.hasClass('expand')) {
                e.removeClass('expand');
                $(this).addClass('expand');
            } else {
                $(this).addClass('expand');
            }
        });
    }
    $('.collapse.show').each(function () {
        $(this).closest('.collapse-custom').addClass('active');
    });

    $('.collapse')
        .on('shown.bs.collapse', function () {
            $(this).closest('.collapse-custom').addClass('active');
        })
        .on('hidden.bs.collapse', function () {
            $(this).closest('.collapse-custom').removeClass('active');
        });
    function collapse() {
        var coll = document.getElementsByClassName('collapsible');
        var i;
        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener('click', function () {
                this.classList.toggle('active');
                var content = this.nextElementSibling;
                if (content.style.maxHeight) {
                    content.style.maxHeight = null;
                    content.style.borderBottom = 'none';
                } else {
                    content.style.maxHeight = content.scrollHeight + 'px';
                    content.style.borderBottom = '1px solid var(--tc-theme-primary)';
                }
            });
        }
    }
    if ($('.text-anime-style-1').length) {
        let staggerAmount = 0.05,
            translateXValue = 0,
            delayValue = 0.5,
            animatedTextElements = document.querySelectorAll('.text-anime-style-1');

        animatedTextElements.forEach((element) => {
            let animationSplitText = new SplitText(element, { type: 'chars, words' });
            gsap.from(animationSplitText.words, {
                duration: 1,
                delay: delayValue,
                x: 20,
                autoAlpha: 0,
                stagger: staggerAmount,
                scrollTrigger: { trigger: element, start: 'top 100%' },
            });
        });
    }
    if ($('.text-anime-style-2').length) {
        let staggerAmount = 0.05,
            translateXValue = 20,
            delayValue = 0.5,
            easeType = 'power2.out',
            animatedTextElements = document.querySelectorAll('.text-anime-style-2');

        animatedTextElements.forEach((element) => {
            let animationSplitText = new SplitText(element, { type: 'chars, words' });
            gsap.from(animationSplitText.chars, {
                duration: 1,
                delay: delayValue,
                x: translateXValue,
                autoAlpha: 0,
                stagger: staggerAmount,
                ease: easeType,
                scrollTrigger: { trigger: element, start: 'top 100%' },
            });
        });
    }

    if ($('.text-anime-style-3').length) {
        let animatedTextElements = document.querySelectorAll('.text-anime-style-3');

        animatedTextElements.forEach((element) => {
            //Reset if needed
            if (element.animation) {
                element.animation.progress(1).kill();
                element.split.revert();
            }

            element.split = new SplitText(element, {
                type: 'lines,words,chars',
                linesClass: 'split-line',
            });
            gsap.set(element, { perspective: 400 });

            gsap.set(element.split.chars, {
                opacity: 0,
                x: '50',
            });

            element.animation = gsap.to(element.split.chars, {
                scrollTrigger: { trigger: element, start: 'top 100%' },
                x: '0',
                y: '0',
                rotateX: '0',
                opacity: 1,
                duration: 1,
                ease: Back.easeOut,
                stagger: 0.02,
            });
        });
    }
    //========== TIMER ============= //

    function startCountdown(targetDate, elementIdsList) {
        var countdownFunction = setInterval(function () {
            var now = new Date().getTime();
            var distance = targetDate - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Zero-padding function
            function formatNumber(num) {
                return num < 10 ? '0' + num : num;
            }

            // Update all element sets
            elementIdsList.forEach((ids) => {
                let daysEl = document.getElementById(ids.days);
                let hoursEl = document.getElementById(ids.hours);
                let minutesEl = document.getElementById(ids.minutes);
                let secondsEl = document.getElementById(ids.seconds);

                // Kiểm tra phần tử tồn tại trước khi cập nhật
                if (daysEl && hoursEl && minutesEl && secondsEl) {
                    daysEl.innerHTML = formatNumber(days);
                    hoursEl.innerHTML = formatNumber(hours);
                    minutesEl.innerHTML = formatNumber(minutes);
                    secondsEl.innerHTML = formatNumber(seconds);
                }
            });

            if (distance < 0) {
                clearInterval(countdownFunction);
                elementIdsList.forEach((ids) => {
                    let daysEl = document.getElementById(ids.days);
                    let hoursEl = document.getElementById(ids.hours);
                    let minutesEl = document.getElementById(ids.minutes);
                    let secondsEl = document.getElementById(ids.seconds);

                    if (daysEl && hoursEl && minutesEl && secondsEl) {
                        daysEl.innerHTML = '00';
                        hoursEl.innerHTML = '00';
                        minutesEl.innerHTML = '00';
                        secondsEl.innerHTML = '00';
                    }
                });
                alert('Countdown Ended');
            }
        }, 1000);
    }

    // Define the target date
    var targetDate = new Date();
    targetDate.setDate(targetDate.getDate() + 12);
    targetDate.setHours(targetDate.getHours() + 22);
    targetDate.setMinutes(targetDate.getMinutes() + 18);
    targetDate.setSeconds(targetDate.getSeconds() + 44);

    // Call with multiple sets of elements
    startCountdown(targetDate, [
        { days: 'days', hours: 'hours', minutes: 'minutes', seconds: 'seconds' },
        { days: 'days1', hours: 'hours1', minutes: 'minutes1', seconds: 'seconds1' },
    ]);

    // POPUP
    // Function to initialize and manage the popup
    function initPopup() {
        // Function to get a cookie value by name
        function getCookie(name) {
            return (
                document.cookie
                    .split('; ')
                    .map((c) => c.split('='))
                    .find((c) => c[0] === name)?.[1] || ''
            );
        }

        // Function to set a cookie with an optional expiration time
        function setCookie(name, value, days) {
            let expires = '';
            if (days) {
                let d = new Date();
                d.setTime(d.getTime() + days * 86400000); // Calculate expiration timestamp (days to milliseconds)
                expires = '; expires=' + d.toUTCString(); // Format expiration date in UTC string
            }
            document.cookie = `${name}=${value}${expires}; path=/`; // Set cookie with name, value, expiration, and path
        }

        // Check if Magnific Popup library is loaded and available
        if (typeof $.fn.magnificPopup === 'function') {
            const popupSelector = '#promotion-popup', // Selector for the popup container (ID from your HTML)
                delaySecond = 1, // Delay in seconds before showing the popup
                expireDays = 30, // Cookie expiration time in days
                cookieName = 'astrax-promotion-popup'; // Unique name for the cookie to track popup dismissal

            // Auto-show popup if it exists and the cookie hasn't been set to 'shown'
            if ($(popupSelector).length && getCookie(cookieName) !== 'hidePopup') {
                setTimeout(() => {
                    $.magnificPopup.open({
                        showCloseBtn: true, // Display the close button
                        closeBtnInside: true, // Position the close button inside the popup
                        items: { src: popupSelector }, // Target the #promotion-popup element as the content source
                        type: 'inline', // Popup content is inline HTML
                        mainClass: 'promotion-popup mfp-with-zoom', // Custom classes for styling and fade effect
                        removalDelay: 300, // Delay in milliseconds before closing for a smooth animation
                        callbacks: {
                            open: function () {
                                // Add click event to .mfp-bg.promotion-popup to close the popup
                                $('.mfp-bg.promotion-popup').on('click', function (e) {
                                    e.preventDefault(); // Prevent any default behavior
                                    $.magnificPopup.close(); // Close the popup when background is clicked
                                });
                            },
                            close: function () {
                                // Check if "Don't show again" checkbox is selected and set cookie accordingly
                                if ($('#promotion-popup-dismiss').is(':checked')) {
                                    setCookie(cookieName, 'hidePopup', expireDays);
                                }
                            },
                        },
                    });
                }, delaySecond * 2000); // Convert delay from seconds to milliseconds (e.g., 1s = 2000ms)
            }

            // Custom click handler for .mfp-close button (optional, as Magnific Popup handles it by default)
            $('.mfp-close').on('click', function (e) {
                e.preventDefault(); // Prevent any default behavior (if applicable)
                $.magnificPopup.close(); // Manually close the popup
            });
        }
    }

    function textTypeWrite() {
        var TxtType = function (el, toRotate, period) {
            this.toRotate = toRotate;
            this.el = el;
            this.loopNum = 0;
            this.period = parseInt(period, 10) || 2000;
            this.txt = '';
            this.isDeleting = false;
            this.tick();
        };

        TxtType.prototype.tick = function () {
            var i = this.loopNum % this.toRotate.length;
            var fullTxt = this.toRotate[i];

            if (this.isDeleting) {
                this.txt = fullTxt.substring(0, this.txt.length - 1);
            } else {
                this.txt = fullTxt.substring(0, this.txt.length + 1);
            }

            this.el.innerHTML = '<span class="wrap">' + this.txt + '</span>';

            var that = this;
            var delta = 200 - Math.random() * 100;

            if (this.isDeleting) {
                delta /= 2;
            }

            if (!this.isDeleting && this.txt === fullTxt) {
                delta = this.period;
                this.isDeleting = true;
            } else if (this.isDeleting && this.txt === '') {
                this.isDeleting = false;
                this.loopNum++;
                delta = 500;
            }

            setTimeout(function () {
                that.tick();
            }, delta);
        };

        // Ensure the script runs when the page loads
        document.addEventListener('DOMContentLoaded', function () {
            var elements = document.getElementsByClassName('typewrite');
            for (var i = 0; i < elements.length; i++) {
                var toRotate = elements[i].getAttribute('data-type');
                var period = elements[i].getAttribute('data-period');
                if (toRotate) {
                    new TxtType(elements[i], JSON.parse(toRotate), period);
                }
            }
        });
    }

    textTypeWrite();

    /*=============================================
    =           Page Load       =
    =============================================*/
    $(window).on('load', function () {
        preloader();
        progressPageLoad();
        offcanvasMenu();
        dataBackground();
        aosAnimation();
        counterState();
        customSwiper();
        magnificPopup();
        wowAnimation();
        odometerCounter();
        mobileHeaderActive();
        carauselScroll();
        cardScroll();
        collapse();
        accordion();
        masonryFillter();
        initPopup();
    });
})(jQuery);
