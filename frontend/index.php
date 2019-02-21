<?php
    if (isset($_POST['submit'])){
      header("Location: ?form={$_POST['form']}&slice={$_POST['slice']}");
    }

    if(isset($_GET['slice']))
        $slice = $_GET['slice'];
    else
        $slice = 0;

    if(isset($_GET['form']))
        $form = $_GET['form'];
    else
        $form = null;

    if(isset($_GET['e']))
        $e = 1;
    else
        $e = 0;
 
    if(isset($_GET['w']))
        $w = 1;
    else
        $w = 0;

    $autologin = false;

    $time_asterisk_authorization = 90;
    $url_asterisk_authorization = '/check';
    $url_default = '/';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=10; IE=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="-1">
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

                    <?php if($autologin): ?>
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

                    <?php if($e==1 || $w==1):?>
                    <div class="block-container">
                        <?php if($e==1):?>
                        <div class="block-container__inner block-container__error">
                            Ошибка
                        </div>
                        <?php endif; ?>

                        <?php if($w==1):?>
                        <div class="block-container__inner block-container__warning">
                            Прежупреждение
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
                                    <?php if($form==='form-phone'): ?>
                                        <div class="timer">
                                            <p>ЗВОНИ НА НОМЕР <span class="timer__phone"></span> И БУДЕТ ТЕБЕ ИНТЕРНЕТ</p>
                                            <a href="tel:84983164444">8(498)316-44-44</a>
                                            <p>Втечении <span class="timer__time"></span> с возможно позвонить!</p>
                                        </div>
                                    <?php else: ?>
                                    <form id="form-phone" method="post" class="va-form">
                                        <div class="va-form__block">
                                            <label class="va-form__label">Укажите ваш номер телефона
                                                <input type="text" class="va-form__input" name="phone" placeholder="89161234567" value="">
                                            </label>
                                        </div>
                                        <div class="va-form__block">
                                            <input type="hidden" name="form" value="form-phone">
                                            <input type="hidden" name="slice" value="1">

                                            <button type="submit" class="va-form__submit" name="submit">
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
                                    <?php if($form=='form-pass'): ?>
                                    <form id="form-pass" method="post" class="va-form">
                                        <div class="va-form__block">
                                            <label class="va-form__label">Введите полученный пароль
                                                <input type="password" class="va-form__input" name="password" placeholder="пароль" value="">
                                            </label>
                                        </div>
                                        <div class="va-form__block">
                                            <input type="hidden" name="form" value="form-pass">
                                            <input type="hidden" name="slice" value="3">

                                            <button type="submit" class="va-form__submit" name="submit">
                                                <img src="<%= require('./scss/layout/wrapper__va-container/sms-small.png') %>"
                                                     srcset="<%= require('./scss/layout/wrapper__va-container/sms-small@2x.png') %> 2x, <%= require('./scss/layout/wrapper__va-container/sms-small@3x.png') %> 3x">
                                                <span>Авторизация</span>
                                            </button>
                                        </div>

                                        <div class="va-form__block">
                                            <button type="button" class="va-form__button">
                                                <span>Получить пароль</span>
                                            </button>
                                        </div>
                                    </form>
                                    <?php else: ?>
                                    <form id="form-sms" method="post" class="va-form">
                                        <div class="va-form__block">
                                            <label class="va-form__label">Укажите ваш номер телефона
                                                <input type="text" class="va-form__input" name="phone" placeholder="89161234567" value="">
                                            </label>
                                        </div>
                                        <div class="va-form__block">
                                            <input type="hidden" name="form" value="form-sms">
                                            <input type="hidden" name="slice" value="3">

                                            <button type="submit" class="va-form__submit" name="submit">
                                                <img src="<%= require('./scss/layout/wrapper__va-container/sms-small.png') %>"
                                                     srcset="<%= require('./scss/layout/wrapper__va-container/sms-small@2x.png') %> 2x, <%= require('./scss/layout/wrapper__va-container/sms-small@3x.png') %> 3x">
                                                <span>Авторизация</span>
                                            </button>
                                        </div>

                                        <div class="va-form__block">
                                            <button type="button" class="va-form__button">
                                                <span>Ввести пароль</span>
                                            </button>
                                        </div>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!--ISTRANET.RU-->
                            <div class="va-slice va-slice-4 va-container__inner_slice-next">
                                <div class="va-slice__title">
                                    <div class="va-slice__title_inner">
                                        <img src="<%= require('./scss/layout/wrapper__va-container/istra.png') %>"
                                             srcset="<%= require('./scss/layout/wrapper__va-container/istra@2x.png') %> 2x, <%= require('./scss/layout/wrapper__va-container/istra@3x.png') %> 3x">
                                        Логин ISTRANET.RU
                                    </div>
                                </div>
                                <div class="va-slice__content">
                                    <form id="form-istra" method="post" class="va-form">
                                        <div class="va-form__block">
                                            <label class="va-form__label">Введите логин и пароль istranet.ru
                                                <input type="text" class="va-form__input" name="phone" placeholder="логин" value="">
                                            </label>
                                        </div>
                                        <div class="va-form__block">
                                            <input type="password" class="va-form__input" name="password" placeholder="пароль" value="">
                                        </div>
                                        <div class="va-form__block">
                                            <input type="hidden" name="form" value="form-istra">
                                            <input type="hidden" name="slice" value="4">

                                            <button type="submit" class="va-form__submit" name="submit">
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
                </div>

                <div class="wrapper__inner wrapper__sites">
                    <div class="sites">
                        <div class="sites__button"><a href="#">ЖитьВистре.рф</a></div>
                        <div class="sites__button"><a href="#">Дедовск Online</a></div>
                        <div class="sites__button"><a href="#">Новый Иерусалим</a></div>
                        <div class="sites__button"><a href="#">Facebook InstaRF</a></div>
                        <div class="sites__button"><a href="#">Facebook InstaRF</a></div>
                        <div class="sites__button sites__button_empty"></div>
                        <div class="clearboth"></div>
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
        var optionsSlices = {
            slice: <?php echo $slice; ?>,
            form: '<?php echo $form; ?>',
            time_asterisk_authorization: <?php echo $time_asterisk_authorization; ?>,
            url_asterisk_authorization: '<?php echo $url_asterisk_authorization; ?>',
            url_default: '<?php echo $url_default; ?>',
            error_timer: 'Время закончилось. Вы будите перенапрвлены на начальную страницу!'
        }
    </script>
</body>
</html>