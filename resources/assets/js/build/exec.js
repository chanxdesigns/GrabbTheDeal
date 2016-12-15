(function (GTDLib) {
    $(window).on("load", GTDLib.bootstrap());
    $('.close').click(function (e) {
        e.preventDefault();
        $(this).parent().parent().parent().hide();
    });
    var tooltipMsg = {
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
    $(document).click(GTDLib.tooltip(tooltipMsg, "how-it-works"));
    $('.form-icon').click(GTDLib.submitSearch);
    $('#header-search-form').submit(GTDLib.submitSearch);
    $('.with-dd, .sub-menu').hover(function (e) {
        e.preventDefault();
        $(this).parents('.main-menu-lists').find('.main-menu-link').addClass('hover');
        $(this).parents('.main-menu-lists').find('.sub-menu').show();
    }, function () {
        $(this).parents('.main-menu-lists').find('.main-menu-link').removeClass('hover');
        $(this).parents('.main-menu-lists').find('.sub-menu').hide();
    });
    $('.user-menu-lists').hover(function (e) {
        e.preventDefault();
        $(this).parent().find('.user-sub-menu').stop(true, true).show().animate({
            marginTop: '23px',
        }, 300);
    }, function () {
        $(this).parent().find('.user-sub-menu').stop(true, true).hide().animate({
            marginTop: '10px',
        }, 300);
    });
    $('#sort').change(GTDLib.sortOffers);
    var main_carousel = $('.main-featured');
    main_carousel.owlCarousel({
        items: 1,
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
    var today_deals_carousel = $('#today-deals-slider');
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
    $('.today-deals-card a').click(GTDLib.clickSourceDetect);
    $(".top-stores-card").hover(function () {
        $(this).find('.top-stores-det').show().stop(true, true).animate({
            height: 105,
        }, 200);
    }, function () {
        $(this).find('.top-stores-det').stop(true, true).animate({
            height: 0,
        }, 200, function () {
            $(this).hide();
        });
    });
    $(".categories-list").hover(function () {
        $(this).find('.category-details').show().stop(true, true).animate({
            top: 0
        }, 200);
    }, function () {
        $(this).find('.category-details').stop(true, true).animate({
            top: '220'
        }, 200);
    });
    $('.filter-input').keyup(GTDLib.inputCatFilter);
    $('.cat-filter').change(GTDLib.updateStoresAndCategories);
    $('.cat-filter-wrapper').perfectScrollbar();
    var imgUrl = $('.top-panel').find('input').val();
    if (!imgUrl) {
        var bgColor = "#144e76";
    }
    $('.top-panel').css({
        background: imgUrl ? "url(" + window.location.protocol + "//cdn.grabbthedeal.in/" + imgUrl + ") no-repeat" : bgColor,
        backgroundSize: 'cover'
    });
    $('.see-more-text').click(function (e) {
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
    GTDLib.popupBoxSizing('.popup-store-nav-body');
    $('.stores-list').click(GTDLib.showStorePopup);
    $('.stores-filter').change(GTDLib.updateStoresAndCategories);
    $('.faq-question-text').click(GTDLib.faqToggle);
    $('#contact-form').submit(GTDLib.submitContactForm);
    $('.menu-link').click(GTDLib.switchTab());
    $('#withdrawal-form').submit(GTDLib.requestWithdrawal);
    $('#profile-update').submit(GTDLib.updateProfile);
    $('#support-ticket-generate').click(GTDLib.generateTicket);
    $('#support-form').submit(GTDLib.sendSupportRequest);
    $('.next').click(GTDLib.pagination);
    $('.prev').click(GTDLib.pagination);
    GTDLib.popupBoxSizing('.login');
    var login_form = $('.login-form'), modalHeader = $('.modal-header'), modalFooter = $('.modal-footer');
    $('.signin').click(function (e) {
        e.preventDefault();
        $('.register-wrapper').hide();
        $('.login-wrapper').fadeIn();
    });
    if (window.location.search === "?logged=false") {
        $('.signin').trigger('click');
    }
    function loginBeforeSend() {
        var animOpts = {
            loadingTxt: 'Hold on dear!! .. We are logging you in ... ',
            afterElem: '.modal-header'
        };
        login_form.hide();
        modalHeader.hide();
        modalFooter.hide();
        GTDLib.loadAnimation(animOpts);
    }
    function loginSuccess(res) {
        GTDLib.changeAnimationText('You are logged in!! .. Redirecting you ...');
        window.location.href = window.location.origin + window.location.pathname;
    }
    function loginFailure(res) {
        GTDLib.changeAnimationText('Hold On!! .. Problem logging you in ...');
        var notifElem = $('.notification-topbar');
        notifElem
            .removeClass('loginSuccess');
        notifElem
            .addClass('danger')
            .html('<p>Maybe your username or password is at fault!!</p>')
            .css('display', 'block');
        setTimeout(function () {
            notifElem.slideUp();
        }, 5000);
        $('.loader-wrapper').hide();
        login_form.show();
        modalHeader.show();
        modalFooter.show();
    }
    login_form.submit(GTDLib.login(loginBeforeSend, loginSuccess, loginFailure));
    GTDLib.popupBoxSizing('.register');
    $('.signup').click(function (e) {
        e.preventDefault();
        $('.login-wrapper').hide();
        $('.register-wrapper').fadeIn();
    });
    $('#reg-password').keyup(GTDLib.confirmRegisterPassword);
    $('#confirm_password').keyup(GTDLib.confirmRegisterPassword);
    var register_form = $('.register-form');
    function registerBeforeSend() {
        var animOpts = {
            loadingTxt: 'Hold on dear!! .. We are registering you ... ',
            afterElem: '.modal-header'
        };
        register_form.hide();
        modalHeader.hide();
        modalFooter.hide();
        GTDLib.loadAnimation(animOpts);
    }
    function registerSuccess(res) {
        GTDLib.changeAnimationText('You are registered!! .. Redirecting you ...');
        window.location.href = window.location.origin + window.location.pathname + window.location.search ? window.location.search : '';
    }
    function registerFailure(res) {
        GTDLib.changeAnimationText('There was a problem registering you!!');
        var notifElem = $('.notification-topbar');
        notifElem
            .removeClass('success');
        notifElem
            .addClass('danger')
            .html('<p>Email Already Registered</p>')
            .css('display', 'block');
        setTimeout(function () {
            notifElem.slideUp();
        }, 5000);
        $('.loader-wrapper').hide();
        register_form.show();
        modalHeader.show();
        modalFooter.show();
    }
    register_form.submit(GTDLib.register(registerBeforeSend, registerSuccess, registerFailure));
    $('#new-password').keyup(GTDLib.confirmResetPass);
    $('#new-password-conf').keyup(GTDLib.confirmResetPass);
})(GTDLib);
//# sourceMappingURL=exec.js.map