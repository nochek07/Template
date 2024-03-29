import $ from 'jquery';
window.jQuery = $;
require('fancybox/dist/js/jquery.fancybox.pack.js');

(function($) {
    let methods = {
        slices: {},
        options: {
            animSpeed: 400
        },
        timer: {
            id:   0,
            time: 80
        },
        timerCheck: {
            id:   0,
            time: 0
        },
        error_timer: '',
        init: function (params) {
            if (this.length) {
                return this.each(function () {
                    methods.options = $.extend({}, methods.options, params);

                    methods.selectSlice(this);
                    methods.initBindObject(this);
                    methods.formSubmit(this);

                    if (methods.options.form === 'form-asterisk') {
                        methods.timer.time = methods.options.time_asterisk_authorization;

                        methods.timerCheck.time = methods.timer.time + 6;
                        let timer = $('.timer__time', this),
                            timerMain = $('.timer', this);
                        timer.text(methods.timer.time);

                        methods.timerId      = setInterval(methods.startTimer, 1000, timerMain, timer);
                        methods.timerIdCheck = setInterval(methods.startTimerCheck, 2000);
                        methods.check();
                    }

                    methods.slices = $(this).find('div.va-slice');

                    if (methods.slices) {
                        methods.slices.each(function () {
                            let parentSlice = $(this);
                            $('.va-slice__title', parentSlice).bind('click.slices', {parent: parentSlice}, methods.clickSlice);
                        });
                    }

                    $('.va-form__label_checkbox', this).parent('.va-form__block').hide();
                });
            }
        },
        clickSlice: function (eventObject) {
            if (methods.slices) {
                methods.slices.each(function () {
                    let content = $('.va-slice__content', this);

                    content.hide(methods.options.animSpeed);
                    if ($(this).get(0) === eventObject.data.parent.get(0)
                        && content.css('display') === 'none') {
                        content.show(methods.options.animSpeed);
                    }
                });
            }
        },
        selectSlice: function (obj) {
            if (methods.options.slice !== undefined) {
                $('.va-slice-' + methods.options.slice + ' .va-slice__content', obj).show(100);
            }
        },
        initBindObject: function (obj) {
            let slices = $(".va-form__button", obj);
            slices.each(function () {
                let parent = $(this).parents('.va-slice'),
                    form = $(this).data('form');
                if (form !== undefined) {
                    let param = {
                        form: form,
                        slice: $("input[name$='[slice]']", parent).val()
                    };
                    $(this).bind('click.slices', param, methods.clickObject);
                }
            });
        },
        clickObject: function (eventObject) {
            window.location.href = '?form=form-' + eventObject.data.form + '&slice=' + eventObject.data.slice;
            return true;
        },
        formSubmit: function (obj) {
            $('form.va-form', obj).bind('submit.slices', function () {
                let phone = $("input[name$='[phone]']", $(this));
                if (phone.length) {
                    let phoneCorrect = /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){6,14}(\s*)?$/;

                    if (!phoneCorrect.test(phone.val())) {
                        phone.addClass('va-form__input_error');
                        return false;
                    } else {
                        phone.removeClass('va-form__input_error');
                    }
                }
                return true;
            });
        },
        startTimer: function (timerMain, timer) {
            if (methods.timer.time === 0) {
                clearInterval(methods.timer.id);
                timerMain.html(methods.options.error_timer);
            } else {
                timer.text(methods.timer.time--);
            }
        },
        startTimerCheck: function () {
            if (methods.timerCheck.time === 0) {
                clearInterval(methods.timerCheck.id);
                window.location.href = '?slice=' + methods.options.slice + '&e=ERROR_SECOND';
            }
            methods.timerCheck.time-=2;
        },
        check: function () {
            $.ajax({
                url: methods.options.url_asterisk_authorization,
                dataType: "json",
                success: function (data) {
                    if (data['status'] === 1) {
                        clearInterval(methods.timerCheck.id);
                        window.location.href = '/';
                    } else if (data['status'] === -1) {
                        clearInterval(methods.timerCheck.id);
                        window.location.href = '?slice=' + methods.options.slice + '&e=ERROR';
                    }
                }
            });
        }
    };

    $.fn.slices = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' +  method + ' does not exist on jQuery.slices');
        }
    };

    $(document).ready(function() {

        $('.va-container').slices(optionsSlices);

        $('.fancybox').fancybox(
            {
                afterShow: function(instance, slide) {
                    let answers = $('.faqs-block__question_answer');
                    $('.faqs-block__question_title').click(function () {

                        let parent = $(this).parent(),
                            content = $('.faqs-block__question_answer', parent);

                        answers.each(function () {
                            let element = $(this),
                                title = $('.faqs-block__question_title', element.parent());

                            if (content.get(0) === element.get(0)) {
                                if (content.css('display') === 'none') {
                                    content.show();
                                    title.addClass('faqs-block__question_titl_rotate');
                                } else {
                                    content.hide();
                                    title.removeClass('faqs-block__question_titl_rotate');
                                }
                            } else {
                                element.hide();
                                title.removeClass('faqs-block__question_titl_rotate');
                            }
                        });
                    });
                }
            }
        );

        $('.autologin-enter a').click(function () {
            setCookie('autologin', 'no', {expires: 43200});
            return true;
        });

        $('.autologin__content button.va-form__submit').click(function(){
            window.location.href = optionsSlices.url_default + 'autologin?phone=' + $(this).data('tel');
            return true;
        });

        function setCookie(name, value, options) {
            options = options || {};

            let expires = options.expires;

            if (typeof expires == "number" && expires) {
                let date = new Date();
                date.setTime(date.getTime() + expires * 1000);
                expires = options.expires = date;
            }
            if (expires && expires.toUTCString) {
                options.expires = expires.toUTCString();
            }

            value = encodeURIComponent(value);

            let updatedCookie = name + "=" + value;

            for (let propName in options) {
                updatedCookie += "; " + propName;
                let propValue = options[propName];
                if (propValue !== true) {
                    updatedCookie += "=" + propValue;
                }
            }
            document.cookie = updatedCookie;
        }
    });

})(jQuery);