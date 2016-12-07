/*!************************************************
 * Library File
 *
 * &copy; 2016 Grabb The Deal
 * Chanx Singha <chandra.kumar@grabbthedeal.in>
 !*/
var GTDLib = {
    bootstrap: function () {
        var path = window.location.pathname, origin = window.location.origin, query = window.location.search;
        var url, category = [], stores = [], sort = '';
        if (query) {
            if (/\/search/g.test(path)) {
                url = query.substring(1).split('&').splice(1);
            }
            else {
                url = query.substring(1).split('&');
            }
            for (var i = 0; i < path.length; i++) {
                url[i] = decodeURI(url[i]).replace(/\[\]/g, '');
            }
            for (var i = 0; i < url.length; i++) {
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
            for (var i = 0; i < category.length; i++) {
                $('.cat-filter').find("#" + category[i]).prop("checked", true);
            }
        }
        if (stores) {
            for (var i = 0; i < stores.length; i++) {
                $('.stores-filter').find("#" + stores[i]).prop("checked", true);
            }
        }
        if (sort) {
            $('#sort').val(sort);
        }
        var regex = /(\/offer-redirect|\/store-redirect|\/deal-redirect)\/?[A-Z0-9\-_]+\/?$/i;
        if (regex.test(path)) {
            console.log("yea");
            var url_1;
            if (regex.exec(path)[1] === '/store-redirect') {
                url_1 = origin + '/load-store/' + $('#redirect-store-id').val().trim();
            }
            else if (regex.exec(path)[1] === '/offer-redirect') {
                url_1 = origin + '/load-offer/' + $('#redirect-offer-id').val().trim();
            }
            else if (regex.exec(path)[1] === '/deal-redirect') {
                url_1 = origin + '/load-deal/' + $('#redirect-deal-id').val().trim();
            }
            var options = {
                method: 'GET',
                url: url_1,
                dataType: 'json'
            };
            $.ajax(options)
                .done(function (res) {
                setTimeout(function () {
                    window.location.href = res;
                }, 1000);
            });
        }
    },
    tooltip: function (tooltipMsg, tooltipName) {
        return function (e) {
            var el = $(e.target), data = el.data();
            if (data.tooltip === tooltipName) {
                $('.tooltip-wrapper').hide();
                if (!el.find('.tooltip-lists').text().trim()) {
                    var tooltipObj = tooltipName.replace(/-/g, '_');
                    for (var i = 0; i < tooltipMsg[tooltipObj].length; i++) {
                        var node = "<li class='tooltip-body'><p><span>" + tooltipMsg[tooltipObj][i].name + ": </span>" + tooltipMsg[tooltipObj][i].data + "</p></li><br>";
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
        };
    },
    loadAnimation: function (options) {
        var animation;
        console.log(options);
        if (Modernizr.cssanimations) {
            var h3 = '';
            animation = '<div class="loader-wrapper">' +
                '<div class="loader">' +
                '<div class="loader__figure"></div>' +
                '<p class="loader__label">' + options.loadingTxt + '</p>' +
                '</div>' +
                '</div>';
            if (options.innerElem) {
                $(options.innerElem).html(animation);
            }
            else {
                $(options.afterElem).after(animation);
            }
        }
        else {
            animation = '<div class="loader-wrapper">' +
                '<h3 class="' + options.txtClassName + '">' + options.loadingTxt + '</h3>' +
                '<div class="loader">' +
                '<img src="https://cdn.grabbthedeal.in/assets/img/loader.gif">' +
                '</div>' +
                '</div>';
            if (options.innerElem) {
                $(options.innerElem).html(animation);
            }
            else {
                $(options.afterElem).after(animation);
            }
        }
    },
    changeAnimationText: function (txt) {
        $('.loader__label').html(txt);
    },
    popupBoxSizing: function (elem) {
        var windowHeight = $(window).height(), windowWidth = $(window).width(), popup_body = $(elem), boxHeight = popup_body.height(), boxWidth = popup_body.width();
        popup_body.css({
            left: ((windowWidth - boxWidth) / 2),
            top: ((windowHeight - boxHeight) / 2)
        });
    },
    submitSearch: function (e) {
        var search = $('#search');
        if (!search.val().trim()) {
            console.log(search.val().trim());
            e.type === "submit" ? e.preventDefault() : e.preventDefault();
            search.css('border-color', 'red');
        }
        else {
            if (e.type === "click") {
                $('#header-search-form').trigger('submit');
            }
        }
    },
    clickSourceDetect: function () {
        var source = $(this).parents('ul').data('clickSource');
        Cookies.set('source', source, { path: '/' });
    },
    sortOffers: function () {
        var url_arr = window.location.search.substring(1).split('&');
        url_arr[0] = '?sort=' + $(this).val();
        if (/\/search/ig.test(location.pathname)) {
            var url_arr_1 = window.location.search.split('&');
            url_arr_1[1] = "sort=" + $(this).val();
            window.location.href = window.location.origin + window.location.pathname + url_arr_1.join('&');
        }
        else {
            window.location.href = window.location.origin + window.location.pathname + url_arr.join('&');
        }
    },
    inputCatFilter: function () {
        var input = $(this).val().trim().toUpperCase(), ul = $(this).parents('.sidebar-categories').find('.cat-filter-wrapper'), filterElem = ul.find('li');
        for (var i = 0; i < filterElem.length; i++) {
            if ($(filterElem[i]).find('input').val().toUpperCase().indexOf(input) > -1) {
                $(filterElem[i]).show();
            }
            else {
                $(filterElem[i]).hide();
            }
        }
    },
    updateStoresAndCategories: function () {
        var catArray = [], storeArray = [], cat = {};
        var catElem = $('.cat-filter').find('input:checked');
        var storeElem = $('.stores-filter').find('input:checked');
        if (catElem.length) {
            for (var i = 0; i < catElem.length; i++) {
                catArray.push(catElem[i].id);
            }
        }
        if (storeElem.length) {
            for (var i = 0; i < storeElem.length; i++) {
                storeArray.push(storeElem[i].id);
            }
        }
        if (/\/offers\/[A-Za-z0-9\-]+/g.test(location.pathname)) {
            cat['categories'] = catArray;
            location.href = location.origin + location.pathname + "?sort=" + $('#sort').val() + "&" + $.param(cat);
        }
        else if (/\/stores/g.test(location.pathname)) {
            console.log(location.pathname);
            cat['categories'] = catArray;
            location.href = location.origin + location.pathname + "?" + $.param(cat);
        }
        else if (/\/category\/?([A-Za-z0-9\-]+)?\/?$/g.test(location.pathname)) {
            cat['categories'] = catArray;
            cat['stores'] = storeArray;
            location.href = location.origin + location.pathname + "?sort=" + $('#sort').val() + "&" + $.param(cat);
        }
        else if (/\/categories\/?([A-Za-z0-9\-]+)?\/?$/g.test(location.pathname)) {
            cat['stores'] = storeArray;
            location.href = location.origin + location.pathname + "?" + $.param(cat);
        }
        else if (/\/search/g.test(location.pathname)) {
            var search_query = location.search.split('&').splice(0);
            cat['categories'] = catArray;
            cat['stores'] = storeArray;
            location.href = location.origin + location.pathname + search_query[0] + "&sort=" + $('#sort').val() + "&" + $.param(cat);
        }
    },
    showStorePopup: function (e) {
        e.preventDefault();
        var storeid = $(this).attr('id'), offersCount = $(this).find('#hid-count').val(), cashbackRate = $(this).find('#hid-cashback').val().trim(), imgUrl = $(this).find('.logo').attr('src'), popupBox = $('.popup-store-nav-body');
        popupBox.find('.popup-store-logo').attr('src', imgUrl);
        popupBox.find('.popup-store-cashback-rate').html("Upto " + cashbackRate + " Cashback");
        if (offersCount > 0) {
            popupBox.find('.popup-store-offers').html(offersCount + " Offers Available");
            popupBox.find('#view-offers').attr('href', window.location.origin + '/offers/' + storeid).show();
            popupBox.find('#visit-store').removeClass('single').attr('href', window.location.origin + '/store-redirect/' + storeid);
        }
        else {
            popupBox.find('.popup-store-offers').html("No Offers Available");
            popupBox.find('#view-offers').hide();
            popupBox.find('#visit-store').addClass('single').attr('href', window.location.origin + '/store-redirect/' + storeid);
        }
        $('.popup-store-wrapper').show();
    },
    faqToggle: function (e) {
        e.preventDefault();
        var elem = $(this).parent().find('.faq-answer');
        $('.faq-answer').not(elem).slideUp();
        if (elem.css('display') === 'none') {
            elem.slideDown();
        }
    },
    submitContactForm: function (e) {
        e.preventDefault();
        $('#contact-submit').hide();
        $(this).find('.loader2').show();
        var that = $(this);
        $.post(window.location.origin + '/contact/send', $(this).serialize())
            .done(function () {
            $('.loader2').hide();
            $('#contact-submit').show();
            var notifElem = $('.notification-topbar');
            notifElem
                .removeClass('danger');
            notifElem
                .addClass('success')
                .html('<p>Contact request successfully sent !</p>')
                .css('display', 'block');
            setTimeout(function () {
                notifElem.slideUp();
            }, 5000);
            that.trigger('reset');
        })
            .fail(function () {
            $('.loader2').hide();
            $('#contact-submit').show();
            var notifElem = $('.notification-topbar');
            notifElem
                .removeClass('success');
            notifElem
                .addClass('danger')
                .html('<p>Please fill the form before clicking \'Submit\'</p>')
                .css('display', 'block');
            setTimeout(function () {
                notifElem.slideUp();
            }, 5000);
        });
    },
    login: function (beforeSend, success, failure) {
        return function (e) {
            e.preventDefault();
            this.beforeSend = beforeSend;
            this.successCallback = success;
            this.failureCallback = failure;
            console.log(this);
            var data = {
                token: $('input[name=_token]').val(),
                email: $('#email').val(),
                password: $('#password').val()
            };
            var options = {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': data.token
                },
                beforeSend: this.beforeSend,
                data: $.param(data)
            }, url = "http://" + window.location.host + "/login";
            var that = this;
            $.ajax(url, options)
                .done(function (res) {
                if (typeof (that.successCallback) === "function") {
                    that.successCallback(res);
                }
            })
                .fail(function (res) {
                if (typeof (that.failureCallback) === "function") {
                    that.failureCallback(res);
                }
            });
        };
    },
    register: function (beforeSend, success, failure) {
        return function (e) {
            e.preventDefault();
            this.beforeSend = beforeSend;
            this.successCallback = success;
            this.failureCallback = failure;
            var data = {
                token: $('input[name=_token]').val(),
                full_name: $('#full_name').val(),
                email: $('#reg-email').val(),
                password: $('#reg-password').val(),
                conf_pass: $('#confirm_password').val(),
                referral_code: $('#referral_code').val()
            };
            if (data.password === data.conf_pass) {
                var options = {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': data.token
                    },
                    beforeSend: this.beforeSend,
                    data: $.param(data)
                }, url = "http://" + window.location.host + "/register";
                var that = this;
                $.ajax(url, options)
                    .done(function (res) {
                    if (typeof (that.successCallback) === "function") {
                        that.successCallback(res);
                    }
                })
                    .fail(function (res) {
                    if (typeof (that.failureCallback) === "function") {
                        that.failureCallback(res);
                    }
                });
            }
            else {
                return;
            }
        };
    },
    confirmRegisterPassword: function () {
        var pass = $('#reg-password').val(), conf = $('#confirm_password').val();
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
    resetPassword: function (e) {
        e.preventDefault();
        var options = {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $(this).find('input[value=_token]').val()
            },
            data: $(this).serialize()
        };
        var that = $(this), pass = $('#new-password').val(), conf = $('#new-password-conf').val();
        if (pass.trim() === conf.trim()) {
            $.ajax(window.location.origin + '/password/reset/new', options)
                .done(function () {
                that.hide();
                $('.password-reset-message').text('Password successfully changed. Redirecting to homepage now.').show();
                setTimeout(function () {
                    window.location.href = window.location.origin;
                }, 3000);
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
    confirmResetPass: function (e) {
        var pass = $('#new-password').val(), conf = $('#new-password-conf').val();
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
    setHeader: function (hash) {
        var headerTxt = {
            dashboard: "Dashboard Summary",
            activity: "Activities Summary",
            bonus: "Bonus Summary",
            withdrawals: "Cash Withdrawals & Summary",
            referrals: "Referrals & Credits",
            profile: "Profile Information",
            payment: "Payment Settings",
            support: "Support & Help"
        };
        if (hash) {
            $.each(headerTxt, function (key, val) {
                if (hash.substring(1) === key) {
                    $('.main-section-header > h1').html(val);
                    return false;
                }
            });
        }
    },
    switchTab: function () {
        return function (e) {
            if (e.type === "click") {
                e.preventDefault();
                $(document).scrollTop(0);
                var hash = $(this).prop('hash');
                $(this).addClass('selected');
                $('.menu-link').not($(this)).removeClass('selected');
                GTDLib.setHeader(hash);
                $('section').css('display', 'none');
                $(hash).css('display', 'block');
                GTDLib.getData(e, hash);
            }
        };
    },
    getData: function (e, hashid, url) {
        var elem = $(hashid);
        switch (hashid) {
            case '#dashboard':
                if (!elem.html().trim()) {
                    var animOptions = {
                        innerElem: hashid
                    };
                    GTDLib.loadAnimation(animOptions);
                    $.get('/user/' + Cookies.get('user_id') + '/dashboard')
                        .done(function (res) {
                    });
                }
                break;
            case '#activity':
                if (url) {
                    var animOptions = {
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
                        var animOptions = {
                            innerElem: hashid + ' .table-body',
                            loadingTxt: 'Getting activities data...'
                        };
                        GTDLib.loadAnimation(animOptions);
                        $.get('/user/' + Cookies.get('user_id') + '/activity')
                            .done(function (res) {
                            GTDLib.onDone(elem, res, '.table-body');
                        });
                    }
                }
                break;
            case '#bonus':
                if (!elem.find('.table-body').html().trim()) {
                    var animOptions = {
                        innerElem: hashid + ' .table-body',
                        loadingTxt: 'Getting bonus credits...'
                    };
                    GTDLib.loadAnimation(animOptions);
                    $.get('/user/' + Cookies.get('user_id') + '/bonus')
                        .done(function (res) {
                        GTDLib.onDone(elem, res, '.table-body');
                    });
                }
                break;
            case '#withdrawals':
                if (url) {
                    var animOptions = {
                        innerElem: hashid + ' .table-body',
                        loadingTxt: 'Getting withdrawals...'
                    };
                    GTDLib.loadAnimation(animOptions);
                    $.get(url)
                        .done(function (res) {
                        GTDLib.onDone(elem, res, '.table-body');
                    });
                }
                else {
                    if (!elem.find('.table-body').html().trim()) {
                        var animOptions = {
                            innerElem: hashid + ' .table-body',
                            loadingTxt: 'Getting withdrawals...'
                        };
                        GTDLib.loadAnimation(animOptions);
                        $.get('/user/' + Cookies.get('user_id') + '/withdrawals')
                            .done(function (res) {
                            GTDLib.onDone(elem, res, '.table-body');
                        });
                    }
                }
                break;
            case '#referrals':
                if (!elem.find('.table-body').html().trim()) {
                    var animOptions = {
                        innerElem: hashid + ' .table-body',
                        loadingTxt: 'Getting referrals...'
                    };
                    GTDLib.loadAnimation(animOptions);
                    $.get('/user/' + Cookies.get('user_id') + '/referrals')
                        .done(function (res) {
                        GTDLib.onDone(elem, res, '.table-body');
                    });
                }
                break;
            case '#profile':
                $.get('/user/' + Cookies.get('user_id') + '/profile')
                    .done(function (res) {
                    $('#name').val(res.full_name);
                    $('#prof-email').val(res.email);
                    $('#phone').val(res.phone);
                    if (res.gender === 'm') {
                        $('#male').prop('checked', true);
                    }
                    else if (res.gender === "f") {
                        $('#female').prop('checked', true);
                    }
                });
                break;
            case '#payment':
                $.get('/user/' + Cookies.get('user_id') + '/payment')
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
    onDone: function (thisObj, res, selector) {
        var next, prev;
        thisObj.find(selector).html(res);
        prev = thisObj.find('.prev-link').attr('href');
        next = thisObj.find('.next-link').attr('href');
        prev ? thisObj.find('.prev').attr('href', prev).show() : thisObj.find('.prev').hide();
        next ? thisObj.find('.next').attr('href', next).show() : thisObj.find('.next').hide();
    },
    onFailure: function () { },
    pagination: function (e) {
        e.preventDefault();
        var hash = "#" + $(this).parents('section').attr('id'), link = $(this).attr('href');
        GTDLib.getData(e, hash, link);
    },
    requestWithdrawal: function (e) {
        e.preventDefault();
        var formData = $(this).serialize(), withdrawalAmount = $('#withdrawal-amount').val().trim(), availableBalance = $('#available-balance').val().trim();
        if (!parseInt(withdrawalAmount)) {
            $('#withdrawal-amount').css('border-color', 'red');
            $(this).parent().find('.failed').html('Please enter withdrawal amount first.').show();
        }
        else if (parseInt(withdrawalAmount) > availableBalance) {
            $('#withdrawal-amount').css('border-color', 'red');
            $(this).parent().find('.failed').html('Amount entered is greater than the withdrawable balance.').show();
        }
        else {
            $('#withdrawal-amount').css('border-color', 'green');
            $(this).parent().find('.failed').hide();
            var options = {
                method: 'POST',
                data: formData,
                context: '#withdrawals',
                statusCode: {
                    200: function () {
                        var notifElem = $('.notification-topbar');
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
                    404: function () {
                        var notifElem = $('.notification-topbar');
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
                    500: function () {
                        var notifElem = $('.notification-topbar');
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
            $(this).find('input[type=submit]').hide();
            $(this).find('.loader2').show();
            $.ajax('/user/' + Cookies.get('user_id') + '/withdrawals/request', options)
                .done(function () {
                $(this).find('#withdrawal-amount').val("");
                $(this).find('.loader2').hide()
                    .prev().show();
                var balance = availableBalance - parseInt(withdrawalAmount);
                $('#available-balance').val(balance);
                $('#curr-available-balance').text(balance);
                var animOptions = {
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
                    var notifElem_1 = $('.notification-topbar');
                    notifElem_1
                        .removeClass('success');
                    notifElem_1
                        .addClass('danger')
                        .html('<p>' + status + '</p>')
                        .css('display', 'block');
                    setTimeout(function () {
                        notifElem_1.slideUp();
                    }, 3000);
                }
                $(this).find('.loader2').hide()
                    .prev().show();
            });
        }
    },
    updateProfile: function (e) {
        e.preventDefault();
        var profileData = $(this).serialize();
        var options = {
            method: 'POST',
            data: profileData,
            context: $('#profile')
        };
        var animOpt = {
            innerElem: '.loader-backdrop',
            loadingTxt: 'Updating your profile...'
        };
        $('#profile').find('.loader-backdrop').show();
        GTDLib.loadAnimation(animOpt);
        $.ajax('/user/' + Cookies.get('user_id') + '/profile/update', options)
            .done(function () {
            var notifElem = $('.notification-topbar');
            notifElem
                .removeClass('danger');
            notifElem
                .addClass('success')
                .html('<p>Profile successfully updated !</p>')
                .css('display', 'block');
            setTimeout(function () {
                notifElem.slideUp();
            }, 3000);
            $(this).find('.loader-backdrop').hide();
        })
            .fail(function () {
            var notifElem = $('.notification-topbar');
            notifElem
                .removeClass('success');
            notifElem
                .addClass('danger')
                .html('<p>Profile updation failed !</p>')
                .css('display', 'block');
            setTimeout(function () {
                notifElem.slideUp();
            }, 3000);
            $(this).find('.loader-backdrop').hide();
        });
    },
    updatePaymentDetails: function (e) {
        e.preventDefault();
        var formData;
        if ($(this).attr('id') === 'bank-transfer') {
            formData = $(this).serialize();
            var animOptions = {
                innerElem: '.loader-backdrop',
                loadingTxt: 'Updating payment details...'
            };
            $('#payment').find('.loader-backdrop').show();
            GTDLib.loadAnimation(animOptions);
            $.post('/user/' + Cookies.get('user_id') + '/payment/update', formData)
                .done(function () {
                var notifElem = $('.notification-topbar');
                notifElem
                    .removeClass('danger');
                notifElem
                    .addClass('success')
                    .html('<p>Payment details updated successfully !</p>')
                    .css('display', 'block');
                setTimeout(function () {
                    notifElem.slideUp();
                }, 3000);
                $('#payment').find('.loader-backdrop').hide();
            })
                .fail(function () {
                var notifElem = $('.notification-topbar');
                notifElem
                    .removeClass('success');
                notifElem
                    .addClass('danger')
                    .html('<p>Payment details updation failed !</p>')
                    .css('display', 'block');
                setTimeout(function () {
                    notifElem.slideUp();
                }, 3000);
                $('#payment').find('.loader-backdrop').hide();
            });
        }
    },
    generateTicket: function () {
        var ticket = "SUP-" + Math.random().toString().substr(16) + "-" + Math.random().toString().substr(13);
        $('#support-ticket').val(ticket);
    },
    sendSupportRequest: function (e) {
        e.preventDefault();
        var supportMsg = $(this).serialize();
        var animOpt = {
            innerElem: '.loader-backdrop',
            loadingTxt: 'Sending your request...'
        };
        $('#support').find('.loader-backdrop').show();
        GTDLib.loadAnimation(animOpt);
        var $this = $(this);
        $.post('/user/' + Cookies.get('user_id') + '/support/request', supportMsg)
            .done(function () {
            $this.trigger('reset');
            $('#support').find('.loader-backdrop').hide();
            var notifElem = $('.notification-topbar');
            notifElem
                .removeClass('danger');
            notifElem
                .addClass('success')
                .html('<p>Support request sent !</p>')
                .css('display', 'block');
            setTimeout(function () {
                notifElem.slideUp();
            }, 3000);
        })
            .fail(function () {
            $('#support').find('.loader-backdrop').hide();
            var notifElem = $('.notification-topbar');
            notifElem
                .removeClass('success');
            notifElem
                .addClass('danger')
                .html('<p>Oops!! Request sending failed..</p>')
                .css('display', 'block');
            setTimeout(function () {
                notifElem.slideUp();
            }, 3000);
        });
    }
};
console.log(GTDLib);
//# sourceMappingURL=lib.js.map;
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
        background: imgUrl ? "url(" + imgUrl + ") no-repeat" : bgColor,
        backgroundSize: 'cover'
    });
    $('.see-more-text').click(function (e) {
        e.preventDefault();
        var elem = $(this).parents('.offer-desc');
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
    $('.stores-filter').change(GTDLib.updateStoresAndCategories);
    $('.stores').click(GTDLib.showStorePopup);
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