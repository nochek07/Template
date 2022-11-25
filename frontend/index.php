<?php
    foreach ($_POST as $key => $item) {
        if (is_array($item)) {
            if (isset($item['submit'])) {
                $nameForm = str_replace('_form', '', $key);
                header("Location: ?form=form-{$nameForm}&slice={$item['slice']}");
                break;
            }
        }
    }

    $slice = $_GET['slice'] ?? 0;
    $form = $_GET['form'] ?? null;
    $error = isset($_GET['e']) ? 1 : 0;
    $warning = isset($_GET['w']) ? 1 : 0;

    $autologin = false;

    $time_asterisk_authorization = 90;
    $url_asterisk_authorization = '/check';
    $url_default = '/';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=11; IE=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="x-rim-auto-match" content="none">
    <title>Title</title>
</head>
<body>
    <div class="page">
        <div class="page__inner">
            <header class="header">
                <div class="header__logo">
                    <a href="/"></a>
                </div>
            </header>

            <main class="wrapper">
                <div class="wrapper__inner wrapper__va-container">

                    <?php if ($autologin): ?>
                        <div class="va-container autologin">
                            <div class="va-container__inner">

                                <div class="autologin__title">
                                    <div class="autologin__title_inner">
                                        <img src="<%= require('./scss/layout/wrapper__va-container/wireless-internet-img.png') %>"
                                             srcset="<%= require('./scss/layout/wrapper__va-container/wireless-internet-img@2x.png') %> 2x, <%= require('./scss/layout/wrapper__va-container/wireless-internet-img@3x.png') %> 3x">
                                        <div class="autologin-block-number">
                                            <div class="autologin-block-number__text">Ваш номер</div>
                                            <div class="autologin-block-number__number">+7 (927) 688-33-40?</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="autologin__content">
                                    <div class="autologin__content_block">
                                        <button type="button" class="va-form__submit" data-tel="79276883340">
                                            <img src="<%= require('./scss/layout/wrapper__va-container/login.png') %>"
                                                 srcset="<%= require('./scss/layout/wrapper__va-container/login@2x.png') %> 2x, <%= require('./scss/layout/wrapper__va-container/login@3x.png') %> 3x">
                                            <span>Войти в интернет</span>
                                        </button>
                                    </div>

                                    <div class="autologin__content_block autologin-enter">
                                        <a href="/">Другие способы входа</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!$autologin): ?>

                        <?php if ($error == 1 || $warning == 1): ?>
                            <div class="block-container">
                                <?php if ($error == 1): ?>
                                    <div class="block-container__inner block-container__error">
                                        Ошибка
                                    </div>
                                <?php else: ?>
                                    <div class="block-container__inner block-container__warning">
                                        Предупреждение
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <div class="text-container">Выберите способ авторизации</div>

                        <div class="va-container">
                            <div class="va-container__inner">

                                <!--Asterisk-->
                                <div class="va-slice va-slice-1 va-container__inner_slice-first">
                                    <div class="va-slice__title">
                                        <div class="va-slice__title_inner">
                                            <img src="<%= require('./scss/layout/wrapper__va-container/bell.png') %>"
                                                 srcset="<%= require('./scss/layout/wrapper__va-container/bell@2x.png') %> 2x, <%= require('./scss/layout/wrapper__va-container/bell@3x.png') %> 3x">
                                            По звонку
                                        </div>
                                    </div>
                                    <div class="va-slice__content">
                                        <?php if ($form === 'form-asterisk'): ?>
                                            <div class="timer">
                                                <p>ЗВОНИ НА НОМЕР <span class="timer__phone"></span> И БУДЕТ ТЕБЕ ИНТЕРНЕТ</p>
                                                <a href="tel:84983164444">8(498)316-44-44</a>
                                                <p>В течении <span class="timer__time"></span> с возможно позвонить!</p>
                                            </div>
                                        <?php else: ?>
                                            <form id="form-asterisk" name="asterisk_form" method="post" class="va-form">
                                                <div class="va-form__block">
                                                    <label class="va-form__label">Укажите ваш номер телефона
                                                        <input type="text" class="va-form__input" name="asterisk_form[phone]" placeholder="89161234567" value="">
                                                    </label>
                                                </div>
                                                <div class="va-form__block">
                                                    <input type="hidden" name="asterisk_form[slice]" value="1">

                                                    <button type="submit" class="va-form__submit" name="asterisk_form[submit]">
                                                        <img src="<%= require('./scss/layout/wrapper__va-container/bell-small.png') %>"
                                                             srcset="<%= require('./scss/layout/wrapper__va-container/bell-small@2x.png') %> 2x, <%= require('./scss/layout/wrapper__va-container/bell-small@3x.png') %> 3x">
                                                        <span>Авторизация</span>
                                                    </button>
                                                </div>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!--SocialNetwork-->
                                <div class="va-slice va-slice-2 va-container__inner_slice-next">
                                    <div class="va-slice__title">
                                        <div class="va-slice__title_inner">
                                            <img src="<%= require('./scss/layout/wrapper__va-container/vk.png') %>"
                                                 srcset="<%= require('./scss/layout/wrapper__va-container/vk@2x.png') %> 2x, <%= require('./scss/layout/wrapper__va-container/vk@3x.png') %> 3x">
                                            Через соц. сети
                                        </div>
                                    </div>
                                    <div class="va-slice__content">
                                    </div>
                                </div>

                                <!--SMS-->
                                <div class="va-slice va-slice-3 va-container__inner_slice-next">
                                    <div class="va-slice__title">
                                        <div class="va-slice__title_inner">
                                            <img src="<%= require('./scss/layout/wrapper__va-container/sms.png') %>"
                                                 srcset="<%= require('./scss/layout/wrapper__va-container/sms@2x.png') %> 2x, <%= require('./scss/layout/wrapper__va-container/sms@3x.png') %> 3x">
                                            По СМС
                                        </div>
                                    </div>
                                    <div class="va-slice__content">
                                        <?php if ($form === 'form-smspass'): ?>
                                            <form id="form-smspass" name="smspass_form" method="post" class="va-form">
                                                <div class="va-form__block">
                                                    <label class="va-form__label">Введите полученный пароль
                                                        <input type="password" class="va-form__input" name="smspass_form[password]" placeholder="пароль" value="">
                                                    </label>
                                                </div>
                                                <div class="va-form__block">
                                                    <input type="hidden" name="smspass_form[slice]" value="3">

                                                    <button type="submit" class="va-form__submit" name="smspass_form[submit]">
                                                        <img src="<%= require('./scss/layout/wrapper__va-container/sms-small.png') %>"
                                                             srcset="<%= require('./scss/layout/wrapper__va-container/sms-small@2x.png') %> 2x, <%= require('./scss/layout/wrapper__va-container/sms-small@3x.png') %> 3x">
                                                        <span>Авторизация</span>
                                                    </button>
                                                </div>

                                                <div class="va-form__block">
                                                    <button type="button" class="va-form__button" data-form="sms">
                                                        <span>Получить пароль</span>
                                                    </button>
                                                </div>
                                            </form>
                                        <?php else: ?>
                                            <form id="form-sms" name="sms_form" method="post" class="va-form">
                                                <div class="va-form__block">
                                                    <label class="va-form__label">Укажите ваш номер телефона
                                                        <input type="text" class="va-form__input" name="sms_form[phone]" placeholder="89161234567" value="">
                                                    </label>
                                                </div>
                                                <div class="va-form__block">
                                                    <input type="hidden" name="sms_form[slice]" value="3">

                                                    <button type="submit" class="va-form__submit" name="sms_form[submit]">
                                                        <img src="<%= require('./scss/layout/wrapper__va-container/sms-small.png') %>"
                                                             srcset="<%= require('./scss/layout/wrapper__va-container/sms-small@2x.png') %> 2x, <%= require('./scss/layout/wrapper__va-container/sms-small@3x.png') %> 3x">
                                                        <span>Авторизация</span>
                                                    </button>
                                                </div>

                                                <div class="va-form__block">
                                                    <button type="button" class="va-form__button" data-form="smspass">
                                                        <span>Ввести пароль</span>
                                                    </button>
                                                </div>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!--Reseption-->
                                <div class="va-slice va-slice-4 va-container__inner_slice-next">
                                    <div class="va-slice__title">
                                        <div class="va-slice__title_inner">
                                            <img src="<%= require('./scss/layout/wrapper__va-container/istra.png') %>"
                                                 srcset="<%= require('./scss/layout/wrapper__va-container/istra@2x.png') %> 2x, <%= require('./scss/layout/wrapper__va-container/istra@3x.png') %> 3x">
                                            У администратора
                                        </div>
                                    </div>
                                    <div class="va-slice__content">
                                        <form id="form-reseption" name="reseption_form" method="post" class="va-form">
                                            <div class="va-form__block">
                                                <label class="va-form__label">Укажите ваш номер телефона
                                                    <input type="text" class="va-form__input" name="reseption_form[phone]" placeholder="89123456789" value="">
                                                </label>
                                            </div>
                                            <div class="va-form__block">
                                                <input type="password" class="va-form__input" name="reseption_form[password]" placeholder="пароль" value="">
                                            </div>
                                            <div class="va-form__block">
                                                <input type="hidden" name="reseption_form[slice]" value="4">

                                                <button type="submit" class="va-form__submit" name="reseption_form[submit]">
                                                    <img src="<%= require('./scss/layout/wrapper__va-container/login.png') %>"
                                                         srcset="<%= require('./scss/layout/wrapper__va-container/login@2x.png') %> 2x, <%= require('./scss/layout/wrapper__va-container/login@3x.png') %> 3x">
                                                    <span>Авторизация</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                                <!--ISTRANET.RU-->
                                <div class="va-slice va-slice-5 va-container__inner_slice-next">
                                    <div class="va-slice__title">
                                        <div class="va-slice__title_inner">
                                            <img src="<%= require('./scss/layout/wrapper__va-container/istra.png') %>"
                                                 srcset="<%= require('./scss/layout/wrapper__va-container/istra@2x.png') %> 2x, <%= require('./scss/layout/wrapper__va-container/istra@3x.png') %> 3x">
                                            Логин ISTRANET.RU
                                        </div>
                                    </div>
                                    <div class="va-slice__content">
                                        <form id="form-istranet" name="istranet_form" method="post" class="va-form">
                                            <div class="va-form__block">
                                                <label class="va-form__label">Введите логин и пароль istranet.ru
                                                    <input type="text" class="va-form__input" name="istranet_form[login]" placeholder="логин" value="">
                                                </label>
                                            </div>
                                            <div class="va-form__block">
                                                <input type="password" class="va-form__input" name="istranet_form[password]" placeholder="пароль" value="">
                                            </div>
                                            <div class="va-form__block">
                                                <input type="hidden" name="istranet_form[slice]" value="5">

                                                <button type="submit" class="va-form__submit" name="istranet_form[submit]">
                                                    <img src="<%= require('./scss/layout/wrapper__va-container/login.png') %>"
                                                         srcset="<%= require('./scss/layout/wrapper__va-container/login@2x.png') %> 2x, <%= require('./scss/layout/wrapper__va-container/login@3x.png') %> 3x">
                                                    <span>Авторизация</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="wrapper__inner wrapper__sites">
                    <div class="sites">
                        <div class="sites__button"><a href="#">ЖитьВистре.рф</a></div>
                        <div class="sites__button"><a href="#">Дедовск Online</a></div>
                        <div class="sites__button"><a href="#">Новый Иерусалим</a></div>
                        <div class="sites__button"><a href="#">Facebook InstaRF</a></div>
                        <div class="sites__button sites__button_empty_pre"><a href="#">Facebook InstaRF</a></div>
                        <div class="sites__button sites__button_empty"></div>
                        <div class="clearboth"></div>
                    </div>
                </div>

                <div class="wrapper__inner wrapper__sites">
                    <div class="sites">
                        <div class="sites__button_100"><a href="#">Наш сайт</a></div>
                    </div>
                </div>
            </main>
        </div>

        <footer class="footer">
            <div class="footer__inner">
                <div><a href="faq.php" class="fancybox fancybox.ajax">FAQ</a></div>
                <div>Доступ в интернет предоставлен компанией <span class="nowrap">ООО "ISTRANET"</span></div>
                <div>По всем вопросам Вы можете обратиться по <b class="nowrap">8(498)316-44-44</b></div>
            </div>
        </footer>
        
    </div>

    <script type='text/javascript'>
        let optionsSlices = {
            slice: <?php echo $slice; ?>,
            form: '<?php echo $form; ?>',
            time_asterisk_authorization: <?php echo $time_asterisk_authorization; ?>,
            url_asterisk_authorization: '<?php echo $url_asterisk_authorization; ?>',
            url_default: '<?php echo $url_default; ?>',
            error_timer: 'Время закончилось. Вы будите перенаправлены на начальную страницу'
        };
    </script>
</body>
</html>