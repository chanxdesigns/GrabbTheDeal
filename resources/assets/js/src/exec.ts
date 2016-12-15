/// <reference path="references.d.ts"/>

(function (GTDLib) {

    /**********************************************************************
     * Bootstrap the App
     */
    $(window).on("load", GTDLib.bootstrap());

    /**********************************************************************
     * Close Open Popups
     */
    $('.close').click(function (e: Event) {
        e.preventDefault();
        $(this).parent().parent().parent().hide();
    });

    /**********************************************************************
     * Show/Hide Tooltip
     */
    let tooltipMsg = {
        how_it_works: [
            {
                name: "Step 1",
                data: "Register or Login to Grabb The Deal."
            },
            {
                name: "Step 2",
                data: "Browse offers and click on the offer name or Grabb The Deal button."
            },
            {
                name: "Step 3",
                data: "You will be redirected to the respective store page."
            },
            {
                name: "Step 4",
                data: "You have to complete the shopping in the same session i.e don't close the browser window before completing the shopping."
            },
            {
                name: "Step 5",
                data: "Don't visit any other coupon, cashbacks and deal sites which may invalidate your cashback tracking."
            },
            {
                name: "Step 6",
                data: "Your cashback will be tracked automatically within 3 - 72 hours."
            }
        ]
    };
    // Invoke if Tooltip is present
    $(document).click(GTDLib.tooltip(tooltipMsg,"how-it-works"));

    // Invoke header search on icon click
    $('.form-icon').click(GTDLib.submitSearch);

    // Invoke header search on enter key submit
    $('#header-search-form').submit(GTDLib.submitSearch);

    /**********************************************************************
     * Main Menu Hover
     */
    $('.with-dd, .sub-menu').hover(function (e: Event) {
        e.preventDefault();
        $(this).parents('.main-menu-lists').find('.main-menu-link').addClass('hover');
        $(this).parents('.main-menu-lists').find('.sub-menu').show();
    }, function () {
        $(this).parents('.main-menu-lists').find('.main-menu-link').removeClass('hover');
        $(this).parents('.main-menu-lists').find('.sub-menu').hide();
    });

    // User dropdown menu on hover
    $('.user-menu-lists').hover(function (e: Event) {
        e.preventDefault();
        $(this).parent().find('.user-sub-menu').stop(true,true).show().animate({
            marginTop: '23px',
        }, 300);
    }, function () {
        $(this).parent().find('.user-sub-menu').stop(true,true).hide().animate({
            marginTop: '10px',
        }, 300);
    });

    // Sort offers on all page
    $('#sort').change(GTDLib.sortOffers);

    /**********************************************************************
     * Carousel for main featured offers
     */
    let main_carousel = $('.main-featured');
    main_carousel.owlCarousel({
        items: 5,
        responsive: false,
        pagination: false,
        autoPlay: 2000,
        stopOnHover: true
    });

    $('.main-featured-wrapper .nav.prev').click(function () {
        main_carousel.trigger('owl.prev');
    });
    $('.main-featured-wrapper .nav.next').click(function () {
        main_carousel.trigger('owl.next');
    });

    /**********************************************************************
     * Carousel for today's deals
     */
    let today_deals_carousel = $('#today-deals-slider');
    today_deals_carousel.owlCarousel({
        items: 4,
        responsive: false,
        pagination: false,
        margin: 10,
        autoPlay: 2000,
        stopOnHover: true
    });

    $('.today-deals .arrow.left').click(function () {
        today_deals_carousel.trigger('owl.prev');
    });
    $('.today-deals .arrow.right').click(function () {
        today_deals_carousel.trigger('owl.next');
    });

    /**********************************************************************
     * Set deal click source
     */
    $('.today-deals-card a').click(GTDLib.clickSourceDetect);

    /**********************************************************************
     * Top Stores hover effect
     * Homepage
     */
    $(".top-stores-card").hover(function () {
        $(this).find('.top-stores-det').show().stop(true,true).animate({
            height: 105,
        }, 200);
    },
    function () {
        $(this).find('.top-stores-det').stop(true,true).animate({
            height: 0,
        }, 200, function () {
            $(this).hide();
        });
    });

    /**********************************************************************
     * Category page display details of parent category on hover
     * Category Filters
     *
     * @return void
     */
    $(".categories-list").hover(function () {
            $(this).find('.category-details').show().stop(true,true).animate({
                top: 0
            },200);
        },
        function () {
            $(this).find('.category-details').stop(true,true).animate({
                top: '220'
            },200);
        });

    // Filter categories list using the input form
    $('.filter-input').keyup(GTDLib.inputCatFilter);

    // Filter the offers/stores list using the options in filter lists
    $('.cat-filter').change(GTDLib.updateStoresAndCategories);

    // Scroll
    $('.cat-filter-wrapper').perfectScrollbar();

    /**********************************************************************
     * Offer page methods
     */

    // Change top panel image background
        var imgUrl = $('.top-panel').find('input').val();
        if (!imgUrl) {
            var bgColor = "#144e76";
        }
        $('.top-panel').css({
            background: imgUrl ? "url(" + window.location.protocol + "//cdn.grabbthedeal.in/" + imgUrl + ") no-repeat" : bgColor,
            backgroundSize: 'cover'
        });
    // See more offer details
    $('.see-more-text').click(function (e: Event) {
        e.preventDefault();
        var elem = $(this).parent().parent();
        if (elem.find('.less').css('display') === "block") {
            elem.find('.less').hide();
            elem.find('.more').show();
        }
        else {
            elem.find('.more').hide();
            elem.find('.less').show();
        }
    });

    /**********************************************************************
     * Stores page methods
     */

    // Set the Store popup body size
    GTDLib.popupBoxSizing('.popup-store-nav-body');

    // Invoke the Store Popup
    $('.stores-list').click(GTDLib.showStorePopup);

    // Filter stores for every page
    $('.stores-filter').change(GTDLib.updateStoresAndCategories);


    /**********************************************************************
     * FAQ Toggle
     */
    $('.faq-question-text').click(GTDLib.faqToggle);


    /**********************************************************************
     * Send Contact Form
     */
    $('#contact-form').submit(GTDLib.submitContactForm);

    /**********************************************************************
     * User Dashboard and Account page methods
     */

    // Switch left hand nav-menu
    $('.menu-link').click(GTDLib.switchTab());

    // Request Withdrawal
    $('#withdrawal-form').submit(GTDLib.requestWithdrawal);

    // Profile Update function
    $('#profile-update').submit(GTDLib.updateProfile);

    // Support Ticket Generate
    $('#support-ticket-generate').click(GTDLib.generateTicket);

    // Support Form Request
    $('#support-form').submit(GTDLib.sendSupportRequest);

    // Data navigation/paginating
    $('.next').click(GTDLib.pagination);
    $('.prev').click(GTDLib.pagination);

    /**********************************************************************
     * Authentication Customization Block
     */

    // Set Login Box Size
    GTDLib.popupBoxSizing('.login');

    // Login Form Customization
    let login_form = $('.login-form'),
        modalHeader = $('.modal-header'),
        modalFooter = $('.modal-footer');

    $('.signin').click(function (e: Event) {
        e.preventDefault();
        $('.register-wrapper').hide();
        $('.login-wrapper').fadeIn();
    });

    if (window.location.search === "?logged=false") {
        $('.signin').trigger('click');
    }

    // Before executing login request, run this function
    function loginBeforeSend () {
        let animOpts: AnimationInterface = {
            loadingTxt: 'Hold on dear!! .. We are logging you in ... ',
            afterElem: '.modal-header'
        };

        login_form.hide();
        modalHeader.hide();
        modalFooter.hide();
        GTDLib.loadAnimation(animOpts);
    }

    // On successful login
    function loginSuccess (res: any) {
        GTDLib.changeAnimationText('You are logged in!! .. Redirecting you ...');
        window.location.href = window.location.origin + window.location.pathname;
    }

    // On login failure
    function loginFailure (res: any) {
        GTDLib.changeAnimationText('Hold On!! .. Problem logging you in ...');
        // Show Error Notification
        let notifElem = $('.notification-topbar');
        notifElem
            .removeClass('loginSuccess');
        notifElem
            .addClass('danger')
            .html('<p>Maybe your username or password is at fault!!</p>')
            .css('display','block');
        setTimeout(function () {
            notifElem.slideUp();
        },5000);
        ///////////////////////////////////////////
        $('.loader-wrapper').hide();
        login_form.show();
        modalHeader.show();
        modalFooter.show();
    }

    login_form.submit(GTDLib.login(loginBeforeSend, loginSuccess, loginFailure));

    // Before executing register request, run this function
    GTDLib.popupBoxSizing('.register');

    $('.signup').click(function (e: Event) {
        e.preventDefault();
        $('.login-wrapper').hide();
        $('.register-wrapper').fadeIn();
    });

    // Password confirm
    $('#reg-password').keyup(GTDLib.confirmRegisterPassword);
    $('#confirm_password').keyup(GTDLib.confirmRegisterPassword);
    
    // Register Form, Modal Show/Hide
    let register_form = $('.register-form');

    function registerBeforeSend () {
        let animOpts: AnimationInterface = {
            loadingTxt: 'Hold on dear!! .. We are registering you ... ',
            afterElem: '.modal-header'
        };

        register_form.hide();
        modalHeader.hide();
        modalFooter.hide();
        GTDLib.loadAnimation(animOpts);
    }

    function registerSuccess (res: any) {
        GTDLib.changeAnimationText('You are registered!! .. Redirecting you ...');
        window.location.href = window.location.origin + window.location.pathname + window.location.search ? window.location.search : '';
    }

    function registerFailure (res: any) {
        GTDLib.changeAnimationText('There was a problem registering you!!');
        // Show Error Notification
        let notifElem = $('.notification-topbar');
        notifElem
            .removeClass('success');
        notifElem
            .addClass('danger')
            .html('<p>Email Already Registered</p>')
            .css('display','block');
        setTimeout(function () {
            notifElem.slideUp();
        },5000);
        /////////////////////////////////////////
        $('.loader-wrapper').hide();
        register_form.show();
        modalHeader.show();
        modalFooter.show();
    }

    register_form.submit(GTDLib.register(registerBeforeSend, registerSuccess, registerFailure));

    /**********************************************************************
     * Reset Password Confirm
     */
    $('#new-password').keyup(GTDLib.confirmResetPass);
    $('#new-password-conf').keyup(GTDLib.confirmResetPass);

})(GTDLib);