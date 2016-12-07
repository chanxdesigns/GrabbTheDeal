/// <reference path="references.d.ts"/>
/*!************************************************
 * Library File
 *
 * &copy; 2016 Grabb The Deal
 * Chanx Singha <chandra.kumar@grabbthedeal.in>
 !*/

// Library Interface
interface GTDLibInterface {
    bootstrap(): void,
    tooltip(arg1: any, arg2: string): void,
    loadAnimation(arg1: AnimationInterface): void,
    changeAnimationText(arg1: string): void,
    popupBoxSizing(arg1: string): void,
    submitSearch(arg1: Event): void,
    clickSourceDetect(): void,
    sortOffers(): void,
    inputCatFilter(): void,
    updateStoresAndCategories(): void,
    showStorePopup(arg1: Event): void,
    faqToggle(arg1: Event): void,
    submitContactForm(arg1: Event): void,
    login(arg1, arg2, arg3): void,
    register(arg1, arg2, arg3): void,
    confirmRegisterPassword(): void,
    resetPassword(e: Event): void,
    confirmResetPass(e: Event): void,
    setHeader(arg1: string): void,
    switchTab(): void,
    getData(arg1: Event, arg2?: string, arg3?: string): void,
    onDone(arg1: JQuery, arg2: any, arg3: string): void,
    onFailure(): void
    pagination(ar1: Event): void,
    requestWithdrawal(arg1: Event): void,
    updateProfile(arg1: Event): void,
    updatePaymentDetails(arg1: Event): void,
    generateTicket(): void,
    sendSupportRequest(arg1: Event): void
}

// Login Interface
interface LoginInterface {
    token: string,
    email: string,
    password: string
}

// Register Interface
interface RegisterInterface {
    token: string,
    email: string,
    full_name: string,
    password: string,
    conf_pass: string,
    referral_code?: string
}

// Animation Interface
interface AnimationInterface {
    txtClassName?: string;
    loadingTxt?: string;
    innerElem?: string;
    afterElem?: string;
}

/********************************************************************************
 * Library Object
 */

let GTDLib:GTDLibInterface = {

    /***************************************
     * Independent Methods
     */

    // Bootstrap the App and set URL query strings
    // values in page(if applicable)
    bootstrap: function () {
        let path = window.location.pathname,
            origin = window.location.origin,
            query = window.location.search;

        // Set Categories And Stores from URL query strings
        let url: string[],
            category: string[] = [],
            stores: string[] = [],
            sort: string = '';

        if (query) {
            if (/\/search/g.test(path)) {
                url = query.substring(1).split('&').splice(1);
            }
            else {
                url = query.substring(1).split('&');
            }

            for (let i = 0; i < path.length; i++) {
                url[i] = decodeURI(url[i]).replace(/\[\]/g,'');
            }

            for (let i = 0; i < url.length; i++) {
                var p = url[i].split('=');
                if (p[0] === "categories") {
                    category.push(p[1]);
                }
                else if (p[0] === "stores") {
                    stores.push(p[1]);
                }
                else if (p[0] === "sort") {
                    sort = p[1];
                }
            }
        }

        if (category) {
            for(let i = 0; i < category.length; i++) {
                $('.cat-filter').find("#"+category[i]).prop("checked",true);
            }
        }
        if (stores) {
            for(let i = 0; i < stores.length; i++) {
                $('.stores-filter').find("#"+stores[i]).prop("checked",true);
            }
        }
        if (sort) {
            $('#sort').val(sort);
        }

        // Redirect Function for Offers and Store Pages/Links
        let regex = /(\/offer-redirect|\/store-redirect|\/deal-redirect)\/?[A-Z0-9\-_]+\/?$/i;
        if (regex.test(path)) {
            console.log("yea");
            let url: string;
            if (regex.exec(path)[1] === '/store-redirect') {
                url = origin + '/load-store/' + $('#redirect-store-id').val().trim();
            }
            else if (regex.exec(path)[1] === '/offer-redirect') {
                url = origin + '/load-offer/' + $('#redirect-offer-id').val().trim();
            }
            else if (regex.exec(path)[1] === '/deal-redirect') {
                url = origin + '/load-deal/' + $('#redirect-deal-id').val().trim();
            }

            let options: JQueryAjaxSettings = {
                method: 'GET',
                url: url,
                dataType: 'json'
            };

            $.ajax(options)
                .done(function (res) {
                    setTimeout(function () {
                        window.location.href = res;
                    },1000);
                });
        }
    },

    // Offer Tooltip
    tooltip: function (tooltipMsg: any,tooltipName: string) {
        return function (e: Event) {
            let el = $(e.target),
                data = el.data();

            if (data.tooltip === tooltipName) {
                $('.tooltip-wrapper').hide();
                if (!el.find('.tooltip-lists').text().trim()) {
                    let tooltipObj = tooltipName.replace(/-/g,'_');
                    for (var i = 0; i < tooltipMsg[tooltipObj].length; i++) {
                        let node = "<li class='tooltip-body'><p><span>" + tooltipMsg[tooltipObj][i].name + ": </span>" + tooltipMsg[tooltipObj][i].data + "</p></li><br>";
                        el.find('.tooltip-lists').append(node);
                    }
                    el.find('.tooltip-wrapper').show();
                }
                else {
                    el.find('.tooltip-wrapper').toggle();
                }
            }

            if (!$(el).closest('.footer-small-text').length) {
                $('.tooltip-wrapper').hide();
            }
        }
    },

    loadAnimation: function (options: AnimationInterface): void {

        // Instantiate Bounce Object
        let animation: string;

        console.log(options);

        if(Modernizr.cssanimations) {
            let h3: string = '';
            animation = '<div class="loader-wrapper">' +
                '<div class="loader">'+
                '<div class="loader__figure"></div>'+
                '<p class="loader__label">'+ options.loadingTxt +'</p>'+
                '</div>'+
                '</div>';

            if (options.innerElem) {
                $(options.innerElem).html(animation);
            } else {
                $(options.afterElem).after(animation);
            }
        }
        // If CSS3 Animations Not Supported
        // Show GIF Animation
        else {
            animation = '<div class="loader-wrapper">' +
                '<h3 class="'+ options.txtClassName +'">'+options.loadingTxt+'</h3>' +
                '<div class="loader">' +
                '<img src="https://cdn.grabbthedeal.in/assets/img/loader.gif">' +
                '</div>' +
                '</div>';

            if (options.innerElem) {
                $(options.innerElem).html(animation);
            } else {
                $(options.afterElem).after(animation);
            }
        }
    },

    // Change Animation text
    changeAnimationText: function (txt: string): void {
        $('.loader__label').html(txt);
    },

    // Pop-up Box Sizing
    popupBoxSizing: function (elem: string) {
        let windowHeight = $(window).height(),
            windowWidth = $(window).width(),
            popup_body = $(elem),
            boxHeight = popup_body.height(),
            boxWidth = popup_body.width();

        popup_body.css({
            left: ((windowWidth - boxWidth) / 2),
            top: ((windowHeight - boxHeight) / 2)
        });
    },

    /***************************************
     * Header Methods
     */

    // Header Search Form Submit
    submitSearch: function (e: Event) {
        let search = $('#search');
        if (!search.val().trim()) {
            console.log(search.val().trim());
            e.type === "submit" ? e.preventDefault() : e.preventDefault();
            search.css('border-color','red');
        } else {
            if (e.type === "click") {
                $('#header-search-form').trigger('submit');
            }
        }
    },

    /***************************************
     * Homepage Methods
     */

    // Click source detection
    clickSourceDetect: function () {
        var source = $(this).parents('ul').data('clickSource');
        Cookies.set('source',source,{path: '/'});
    },

    /***************************************
     * Offers page Methods
     */

    // Sort Offers
    sortOffers: function () {
        let url_arr = window.location.search.substring(1).split('&');
        url_arr[0] = '?sort='+$(this).val();
        if (/\/search/ig.test(location.pathname)) {
            let url_arr = window.location.search.split('&');
            url_arr[1] = "sort="+$(this).val();
            window.location.href = window.location.origin + window.location.pathname + url_arr.join('&');
        }
        else {
            window.location.href = window.location.origin + window.location.pathname + url_arr.join('&');
        }
    },

    /***************************************
     * Categories, Stores and Category Filter
     */

    // Categories list filter
    inputCatFilter: function () {
        let input = $(this).val().trim().toUpperCase(),
            ul = $(this).parents('.sidebar-categories').find('.cat-filter-wrapper'),
            filterElem = ul.find('li');

        for (let i = 0; i < filterElem.length; i++) {
            if ($(filterElem[i]).find('input').val().toUpperCase().indexOf(input) > -1) {
                $(filterElem[i]).show();
            }
            else {
                $(filterElem[i]).hide();
            }
        }
    },

    // Categories and Stores filter
    updateStoresAndCategories: function () {
        let catArray: string[] = [],
            storeArray: string[] = [],
            cat = {};

        let catElem = $('.cat-filter').find('input:checked');
        let storeElem = $('.stores-filter').find('input:checked');

        if (catElem.length) {
            for (let i = 0; i < catElem.length; i++) {
                catArray.push(catElem[i].id);
            }
        }
        if (storeElem.length) {
            for (let i = 0; i < storeElem.length; i++) {
                storeArray.push(storeElem[i].id);
            }
        }

        if (/\/offers\/[A-Za-z0-9\-]+/g.test(location.pathname)) {
            cat['categories'] = catArray;
            location.href = location.origin + location.pathname + "?sort=" + $('#sort').val() +"&" + $.param(cat);
        }
        else if (/\/stores/g.test(location.pathname)) {
            console.log(location.pathname);
            cat['categories'] = catArray;
            location.href = location.origin + location.pathname + "?" + $.param(cat);
        }
        else if (/\/category\/?([A-Za-z0-9\-]+)?\/?$/g.test(location.pathname)) {
            cat['categories'] = catArray;
            cat['stores'] = storeArray;
            location.href = location.origin + location.pathname + "?sort=" + $('#sort').val() +"&" + $.param(cat);
        }
        else if (/\/categories\/?([A-Za-z0-9\-]+)?\/?$/g.test(location.pathname)) {
            cat['stores'] = storeArray;
            location.href = location.origin + location.pathname + "?" + $.param(cat);
        }
        else if (/\/search/g.test(location.pathname)) {
            let search_query = location.search.split('&').splice(0);
            cat['categories'] = catArray;
            cat['stores'] = storeArray;
            location.href = location.origin + location.pathname + search_query[0] + "&sort=" + $('#sort').val() +"&" + $.param(cat);
        }
    },


    /***************************************
     * Stores Page Method
     */

    // Show PopUp stores
    showStorePopup: function (e: Event) {
        e.preventDefault();
        let storeid = $(this).attr('id'),
            offersCount = $(this).find('#hid-count').val(),
            cashbackRate = $(this).find('#hid-cashback').val().trim(),
            imgUrl = $(this).find('.logo').attr('src'),
            popupBox = $('.popup-store-nav-body');

        popupBox.find('.popup-store-logo').attr('src',imgUrl);
        popupBox.find('.popup-store-cashback-rate').html("Upto " + cashbackRate + " Cashback");

        if (offersCount > 0) {
            popupBox.find('.popup-store-offers').html(offersCount + " Offers Available");
            popupBox.find('#view-offers').attr('href',window.location.origin + '/offers/' + storeid).show();
            popupBox.find('#visit-store').removeClass('single').attr('href',window.location.origin + '/store-redirect/' + storeid);
        }
        else {
            popupBox.find('.popup-store-offers').html("No Offers Available");
            popupBox.find('#view-offers').hide();
            popupBox.find('#visit-store').addClass('single').attr('href',window.location.origin + '/store-redirect/' + storeid);
        }
        // Show the Store Popup
        $('.popup-store-wrapper').show();
    },

    /***************************************
     * FAQ toggle
     */

    faqToggle: function (e: Event) {
        e.preventDefault();
        let elem = $(this).parent().find('.faq-answer');
        $('.faq-answer').not(elem).slideUp();
        if (elem.css('display') === 'none') {
            elem.slideDown();
        }
    },

    /***************************************
     * Send Contact Form
     */

    submitContactForm: function (e: Event) {
        e.preventDefault();
        // Set loading animation
        $('#contact-submit').hide();
        $(this).find('.loader2').show();
        let that = $(this);
        // Send contact form data
        $.post(window.location.origin+'/contact/send', $(this).serialize())
            .done(function () {
                $('.loader2').hide();
                $('#contact-submit').show();
                let notifElem = $('.notification-topbar');
                notifElem
                    .removeClass('danger');
                notifElem
                    .addClass('success')
                    .html('<p>Contact request successfully sent !</p>')
                    .css('display','block');
                setTimeout(function () {
                    notifElem.slideUp();
                },5000);
                // Reset form
                that.trigger('reset');
            })
            .fail(function () {
                $('.loader2').hide();
                $('#contact-submit').show();
                let notifElem = $('.notification-topbar');
                notifElem
                    .removeClass('success');
                notifElem
                    .addClass('danger')
                    .html('<p>Please fill the form before clicking \'Submit\'</p>')
                    .css('display','block');//
                setTimeout(function () {
                    notifElem.slideUp();
                },5000);

            })
    },

    /**************************************************************
     * Login, Register Interface & Methods
     * Formally Authentication Block
     */

    // Login Function
    login: function (beforeSend, success, failure) {
        return function (e: Event) {
            e.preventDefault();

            this.beforeSend = beforeSend;
            this.successCallback = success;
            this.failureCallback = failure;
            console.log(this);

            let data: LoginInterface = {
                token: $('input[name=_token]').val(),
                email: $('#email').val(),
                password: $('#password').val()
            };

            // jQueryAjaxSettings options
            let options: JQueryAjaxSettings = {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': data.token
                    },
                    beforeSend: this.beforeSend,
                    data: $.param(data)
                },
                // POST URL
                url = window.location.protocol + "//" + window.location.host + "/login";

            // Hijack this scope
            var that = this;
            // Run the Ajax request
            $.ajax(url, options)
                .done(function (res) {
                    if (typeof(that.successCallback) === "function") {
                        that.successCallback(res);
                    }
                })
                .fail(function (res) {
                    if (typeof(that.failureCallback) === "function") {
                        that.failureCallback(res);
                    }
                });
        }
    },

    // Register Function
    register: function (beforeSend, success, failure) {
        return function (e: Event) {
            e.preventDefault();

            // Callback functions
            this.beforeSend = beforeSend;
            this.successCallback = success;
            this.failureCallback = failure;

            let data: RegisterInterface = {
                token: $('input[name=_token]').val(),
                full_name: $('#full_name').val(),
                email: $('#reg-email').val(),
                password: $('#reg-password').val(),
                conf_pass: $('#confirm_password').val(),
                referral_code: $('#referral_code').val()
            };

            if (data.password === data.conf_pass) {
                // jQueryAjaxSettings options
                let options: JQueryAjaxSettings = {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': data.token
                        },
                        beforeSend: this.beforeSend,
                        data: $.param(data)
                    },
                    // POST URL
                    url = "http://"+window.location.host + "/register";

                // Hijack this scope
                var that = this;
                // Run the Ajax request
                $.ajax(url, options)
                    .done(function (res) {
                        if (typeof(that.successCallback) === "function") {
                            that.successCallback(res);
                        }
                    })
                    .fail(function (res) {
                        if (typeof(that.failureCallback) === "function") {
                            that.failureCallback(res);
                        }
                    });
            }
            else {
                return;
            }
        }
    },

    // Confirm Password For Registration Function
    confirmRegisterPassword: function (): void {
        let pass = $('#reg-password').val(),
            conf = $('#confirm_password').val();

        if (pass && pass !== conf) {
            $('p.failed').text('Passwords doesn\'t match.').show();
        }
        else if (conf && !pass) {
            $('p.failed').text('Please enter the password').show();
        }
        else {
            $('p.failed').hide();
        }
    },
    
    // Reset Password
    resetPassword: function (e: Event) {
        e.preventDefault();
        let options: JQueryAjaxSettings = {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $(this).find('input[value=_token]').val()
            },
            data: $(this).serialize()
        };

        let that = $(this),
            pass = $('#new-password').val(),
            conf = $('#new-password-conf').val();

        if (pass.trim() === conf.trim()) {
            $.ajax(window.location.origin + '/password/reset/new',options)
                .done(function () {
                    that.hide();
                    $('.password-reset-message').text('Password successfully changed. Redirecting to homepage now.').show();
                    setTimeout(function () {
                        window.location.href = window.location.origin;
                    },3000);
                })
                .fail(function (err) {
                    if (err.status === 500) {
                        $('.password-reset-message').text('Somethings wrong with the server.').show();
                    }
                });
        }
        else {
            return;
        }
    },

    // Confirm Password Reset
    confirmResetPass: function (e: Event) {
        let pass = $('#new-password').val(),
            conf = $('#new-password-conf').val();

        if (pass && pass !== conf) {
            $('p.failed').text('Passwords doesn\'t match.').show();
        }
        else if (conf && !pass) {
            $('p.failed').text('Please enter password above.').show();
        }
        else {
            $('p.failed').hide();
        }
    },

    /**************************************************************
     * User Dashboard and Account page methods
     */

    // Set the tab header
    setHeader: function (hash: string): void {
        // Header Title
        let headerTxt = {
            dashboard:      "Dashboard Summary",
            activity:       "Activities Summary",
            bonus:          "Bonus Summary",
            withdrawals:    "Cash Withdrawals & Summary",
            referrals:      "Referrals & Credits",
            profile:        "Profile Information",
            payment:        "Payment Settings",
            support:        "Support & Help"
        };

        if (hash) {
            $.each(headerTxt, function (key,val) {
                if (hash.substring(1) === key) {
                    $('.main-section-header > h1').html(val);
                    return false;
                }
            });
        }
    },

    // Display Tab On Click Of
    // The Menu Link
    //
    // @param thisObj jQuery
    // @param callback Function
    // @return void
    switchTab: function () {
        return function (e: Event) {
            if (e.type === "click") {
                e.preventDefault();

                // Scroll the screen to top
                $(document).scrollTop(0);
                let hash = $(this).prop('hash');

                // Add Selected class to the current click elem
                // Remove selected class from other .menu-link elem
                $(this).addClass('selected');
                $('.menu-link').not($(this)).removeClass('selected');

                // Set Tab Header
                GTDLib.setHeader(hash);

                // Hide all sections
                // And display only the hashed section
                $('section').css('display','none');
                $(hash).css('display','block');

                // Load data server data
                GTDLib.getData(e, hash);
            }
        }
    },

    // Get Tab View data from server
    getData: function (e: Event, hashid?: string, url?: string) {
        let elem = $(hashid);

        switch(hashid) {
            case '#dashboard':
                if (!elem.html().trim()) {
                    let animOptions = {
                        innerElem: hashid
                    };
                    GTDLib.loadAnimation(animOptions);
                    $.get('/user/'+ Cookies.get('user_id') + '/dashboard')
                        .done(function (res) {
                            //
                        })
                }
                break;
            case '#activity':
                if (url) {
                    let animOptions = {
                        innerElem: hashid + ' .table-body',
                        loadingTxt: 'Getting activities data...'
                    };
                    GTDLib.loadAnimation(animOptions);
                    $.get(url)
                        .done(function (res) {
                            GTDLib.onDone(elem, res, '.table-body');
                        });
                }
                else {
                    if (!elem.find('.table-body').html().trim()) {
                        let animOptions = {
                            innerElem: hashid + ' .table-body',
                            loadingTxt: 'Getting activities data...'
                        };
                        GTDLib.loadAnimation(animOptions);
                        $.get('/user/'+ Cookies.get('user_id') + '/activity')
                            .done(function (res) {
                                //
                                GTDLib.onDone(elem, res, '.table-body');
                            });
                    }
                }
                break;
            case '#bonus':
                if (!elem.find('.table-body').html().trim()) {
                    let animOptions = {
                        innerElem: hashid + ' .table-body',
                        loadingTxt: 'Getting bonus credits...'
                    };
                    GTDLib.loadAnimation(animOptions);
                    $.get('/user/'+ Cookies.get('user_id') +'/bonus')
                        .done(function (res) {
                            GTDLib.onDone(elem, res, '.table-body');
                        })
                }
                break;
            case '#withdrawals':
                if (url) {
                    let animOptions = {
                        innerElem: hashid + ' .table-body',
                        loadingTxt: 'Getting withdrawals...'
                    };
                    GTDLib.loadAnimation(animOptions);
                    $.get(url)
                        .done(function (res) {
                            GTDLib.onDone(elem, res, '.table-body')
                        })
                }
                else {
                    if (!elem.find('.table-body').html().trim()) {
                        let animOptions = {
                            innerElem: hashid + ' .table-body',
                            loadingTxt: 'Getting withdrawals...'
                        };
                        GTDLib.loadAnimation(animOptions);
                        $.get('/user/' + Cookies.get('user_id') + '/withdrawals')
                            .done(function (res) {
                                GTDLib.onDone(elem, res, '.table-body')
                            })
                    }
                }
                break;
            case '#referrals':
                if (!elem.find('.table-body').html().trim()) {
                    let animOptions = {
                        innerElem: hashid + ' .table-body',
                        loadingTxt: 'Getting referrals...'
                    };
                    GTDLib.loadAnimation(animOptions);
                    $.get('/user/'+ Cookies.get('user_id') +'/referrals')
                        .done(function (res) {
                            GTDLib.onDone(elem, res, '.table-body');
                        })
                }
                break;
            case '#profile':
                $.get('/user/'+ Cookies.get('user_id') +'/profile')
                    .done(function (res) {
                        $('#name').val(res.full_name);
                        $('#prof-email').val(res.email);
                        $('#phone').val(res.phone);
                        if (res.gender === 'm') {
                            $('#male').prop('checked',true);
                        }
                        else if(res.gender === "f") {
                            $('#female').prop('checked',true);
                        }
                    });
                break;
            case '#payment':
                $.get('/user/'+ Cookies.get('user_id') +'/payment')
                    .done(function (res) {
                        $('#bank-account-name').val(res.bank_account_name);
                        $('#bank-account-number').val(res.bank_account_number);
                        $('#bank-name').val(res.bank_name);
                        $('#bank-ifsc').val(res.bank_ifsc_code);
                        $('#bank-address').val(res.bank_address);
                    });
                break;
        }
    },

    // On tab data load complete
    onDone: function (thisObj: JQuery, res: any, selector?: string) {
        let next: string,
            prev: string;

        thisObj.find(selector).html(res);

        prev = thisObj.find('.prev-link').attr('href');
        next = thisObj.find('.next-link').attr('href');

        prev ? thisObj.find('.prev').attr('href', prev).show() : thisObj.find('.prev').hide();
        next ? thisObj.find('.next').attr('href', next).show() : thisObj.find('.next').hide();
    },

    // On tab data load failure
    onFailure: function () {},

    // Pagination for the user dashboard list items
    pagination: function (e: Event) {
        e.preventDefault();
        let hash = "#" + $(this).parents('section').attr('id'),
            link = $(this).attr('href');

        GTDLib.getData(e, hash, link);
    },

    // Withdrawal Request
    requestWithdrawal: function (e: Event) {
        e.preventDefault();
        // Get the form data and
        // serialize into query
        // string parameters
        let formData = $(this).serialize(),
            withdrawalAmount = $('#withdrawal-amount').val().trim(),
            availableBalance = $('#available-balance').val().trim();

        // Make Ajax Settings
        if (!parseInt(withdrawalAmount)) {
            $('#withdrawal-amount').css('border-color', 'red');
            $(this).parent().find('.failed').html('Please enter withdrawal amount first.').show();
        }
        else if (parseInt(withdrawalAmount) > availableBalance) {
            $('#withdrawal-amount').css('border-color', 'red');
            $(this).parent().find('.failed').html('Amount entered is greater than the withdrawable balance.').show();
        }
        else {
            $('#withdrawal-amount').css('border-color','green');
            $(this).parent().find('.failed').hide();

            let options:JQueryAjaxSettings = {
                method: 'POST',
                data: formData,
                context: '#withdrawals',
                statusCode: {
                    // On Response Status: 200 OK
                    200: function () {
                        let notifElem = $('.notification-topbar');
                        notifElem
                            .removeClass('danger');
                        notifElem
                            .addClass('success')
                            .html('<p>Withdrawal request successfully sent !</p>')
                            .css('display', 'block');
                        setTimeout(function () {
                            notifElem.slideUp();
                        }, 3000);
                    },
                    // On Response Status: 404 NOT FOUND
                    404: function () {
                        let notifElem = $('.notification-topbar');
                        notifElem
                            .removeClass('success');
                        notifElem
                            .addClass('danger')
                            .html('<p>Oops.. withdrawal request failed due to some problem !</p>')
                            .css('display', 'block');
                        setTimeout(function () {
                            notifElem.slideUp();
                        }, 3000);
                    },
                    // On Response Status: 500 INTERNAL SERVER ERROR
                    500: function () {
                        let notifElem = $('.notification-topbar');
                        notifElem
                            .removeClass('success');
                        notifElem
                            .addClass('danger')
                            .html('<p>Hold On.. Some technical error here !!</p>')
                            .css('display', 'block');
                        setTimeout(function () {
                            notifElem.slideUp();
                        }, 3000);
                    }
                }
            };
            // Set loading animation
            $(this).find('input[type=submit]').hide();
            $(this).find('.loader2').show();

            // Send the POST data
            $.ajax('/user/' + Cookies.get('user_id') + '/withdrawals/request', options)
                .done(function () {
                    // Empty the withdrawal input form
                    $(this).find('#withdrawal-amount').val("");
                    $(this).find('.loader2').hide()
                        .prev().show();
                    // Update displayed available balance
                    var balance = availableBalance - parseInt(withdrawalAmount);
                    $('#available-balance').val(balance);
                    $('#curr-available-balance').text(balance);

                    // Refresh history page
                    let animOptions: AnimationInterface = {
                        innerElem: '#withdrawals .table-body',
                        loadingTxt: 'Getting withdrawals...'
                    };
                    GTDLib.loadAnimation(animOptions);
                    $.get('/user/' + Cookies.get('user_id') + '/withdrawals')
                        .done(function (res) {
                            GTDLib.onDone($('#withdrawals'), res, '.table-body');
                        });
                })
                .fail(function (err, status) {
                    if (err.status !== 200 || err.status !== 404 || err.status !== 500) {
                        let notifElem = $('.notification-topbar');
                        notifElem
                            .removeClass('success');
                        notifElem
                            .addClass('danger')
                            .html('<p>' + status + '</p>')
                            .css('display', 'block');
                        setTimeout(function () {
                            notifElem.slideUp();
                        }, 3000);
                    }
                    $(this).find('.loader2').hide()
                        .prev().show();
                });
        }
    },

    /**************************************************************
     * User Profile dashboard
     */
    updateProfile: function (e: Event) {
        e.preventDefault();

        // Get the profile details
        // and serialize into
        // string query
        let profileData = $(this).serialize();

        let options: JQueryAjaxSettings = {
            method: 'POST',
            data: profileData,
            context: $('#profile')
        };
        let animOpt: AnimationInterface = {
            innerElem: '.loader-backdrop',
            loadingTxt: 'Updating your profile...'
        };

        $('#profile').find('.loader-backdrop').show();
        GTDLib.loadAnimation(animOpt);

        $.ajax('/user/'+ Cookies.get('user_id') +'/profile/update', options)
            .done(function () {
                let notifElem = $('.notification-topbar');
                notifElem
                    .removeClass('danger');
                notifElem
                    .addClass('success')
                    .html('<p>Profile successfully updated !</p>')
                    .css('display','block');
                setTimeout(function () {
                    notifElem.slideUp();
                },3000);
                // Hide the loader backdrop
                // and also hides the loader animation
                $(this).find('.loader-backdrop').hide();
            })
            .fail(function () {
                let notifElem = $('.notification-topbar');
                notifElem
                    .removeClass('success');
                notifElem
                    .addClass('danger')
                    .html('<p>Profile updation failed !</p>')
                    .css('display','block');
                setTimeout(function () {
                    notifElem.slideUp();
                },3000);
                // Hide the loader backdrop
                // and also hides the loader aniamtion
                $(this).find('.loader-backdrop').hide();
            });
    },

    // Update Payment Details function
    updatePaymentDetails: function (e: Event) {
        e.preventDefault();
        let formData: string;
        if ($(this).attr('id') === 'bank-transfer') {
            formData = $(this).serialize();

            let animOptions: AnimationInterface = {
                innerElem: '.loader-backdrop',
                loadingTxt: 'Updating payment details...'
            };

            $('#payment').find('.loader-backdrop').show();
            GTDLib.loadAnimation(animOptions);

            $.post('/user/'+ Cookies.get('user_id') +'/payment/update', formData)
                .done(function () {
                    let notifElem = $('.notification-topbar');
                    notifElem
                        .removeClass('danger');
                    notifElem
                        .addClass('success')
                        .html('<p>Payment details updated successfully !</p>')
                        .css('display','block');
                    setTimeout(function () {
                        notifElem.slideUp();
                    },3000);
                    // Hide Loader
                    $('#payment').find('.loader-backdrop').hide();
                })
                .fail(function () {
                    let notifElem = $('.notification-topbar');
                    notifElem
                        .removeClass('success');
                    notifElem
                        .addClass('danger')
                        .html('<p>Payment details updation failed !</p>')
                        .css('display','block');
                    setTimeout(function () {
                        notifElem.slideUp();
                    },3000);
                    // Hide Loader
                    $('#payment').find('.loader-backdrop').hide();
                });
        }
    },

    // Generate Support Ticket
    generateTicket: function (): void {
        let ticket = "SUP-" + Math.random().toString().substr(16) + "-" + Math.random().toString().substr(13);
        $('#support-ticket').val(ticket);
    },
    
    // Send Support Request
    sendSupportRequest: function (e: Event) {
        e.preventDefault();
        let supportMsg = $(this).serialize();

        let animOpt: AnimationInterface = {
            innerElem: '.loader-backdrop',
            loadingTxt: 'Sending your request...'
        };

        $('#support').find('.loader-backdrop').show();
        GTDLib.loadAnimation(animOpt);

        let $this = $(this);
        $.post('/user/'+ Cookies.get('user_id') +'/support/request', supportMsg)
            .done(function () {
                $this.trigger('reset');
                $('#support').find('.loader-backdrop').hide();

                let notifElem = $('.notification-topbar');
                notifElem
                    .removeClass('danger');
                notifElem
                    .addClass('success')
                    .html('<p>Support request sent !</p>')
                    .css('display','block');
                setTimeout(function () {
                    notifElem.slideUp();
                },3000);
            })
            .fail(function () {
                $('#support').find('.loader-backdrop').hide();

                let notifElem = $('.notification-topbar');
                notifElem
                    .removeClass('success');
                notifElem
                    .addClass('danger')
                    .html('<p>Oops!! Request sending failed..</p>')
                    .css('display','block');
                setTimeout(function () {
                    notifElem.slideUp();
                },3000);
            });
    }



};

// HomePage Slider
//GTDLib.