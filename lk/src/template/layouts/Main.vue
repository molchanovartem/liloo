<template>
    <div>
        <v-header/>
        <div class="content-width content-columns">
            <div class="content-columns__column content-column__column_main">
                <router-view></router-view>
            </div>

            <div class="content-columns__column content-column__column_side">

                <div class="content-block content-block_shadow">
                    <v-sidebar/>
                </div>
            </div>



        </div>
        <footer class="footer content-width">

            <div class="footer__parts">

                <div class="footer__part">

                    <div class="font_Gilroy-18-800-000000">Bplus.com © 2005–2018</div>

                    <div class="mt-20">
                        <a href="tel:88002345533" class="button-phone">
                            <span class="button-phone__fa fas fa-phone fa-flip-horizontal"></span>
                            <span class="button-phone__text">8 800 234-55-33</span>
                        </a>
                    </div>

                    <a class="logo mt-35" href="/">
                        <img src="http://upload.wikimedia.org/wikipedia/commons/a/ab/Logo_TV_2015.png" alt="logo" class="logo__img">
                    </a>

                </div>

                <div class="footer__part footer-menus">

                    <div class="footer-menu">
                        <div class="footer-menu__name">Профиль</div>
                        <div class="footer-menu__uls">
                            <ul class="footer-menu__ul">
                                <li class="footer-menu__li">Войти</li>
                                <li class="footer-menu__li">Зарегистрироваться</li>
                                <li class="footer-menu__li"><a href="" class="footer-menu__a">Восстановить доступ</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="footer-menu">
                        <div class="footer-menu__name">Специалисты</div>
                        <div class="footer-menu__uls">
                            <ul class="footer-menu__ul">
                                <li class="footer-menu__li"><a href="" class="footer-menu__a">Косметолог</a></li>
                                <li class="footer-menu__li"><a href="" class="footer-menu__a">Визажист</a></li>
                                <li class="footer-menu__li"><a href="" class="footer-menu__a">Стилист</a></li>
                                <li class="footer-menu__li"><a href="" class="footer-menu__a">Фотограф</a></li>
                            </ul>
                            <ul class="footer-menu__ul">
                                <li class="footer-menu__li"><a href="" class="footer-menu__a">Косметолог</a></li>
                                <li class="footer-menu__li"><a href="" class="footer-menu__a">Визажист</a></li>
                                <li class="footer-menu__li"><a href="" class="footer-menu__a">Стилист</a></li>
                                <li class="footer-menu__li"><a href="" class="footer-menu__a">Брови, ресницы</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="footer-menu">
                        <div class="footer-menu__name">Сервисы</div>
                        <div class="footer-menu__uls">
                            <ul class="footer-menu__ul">
                                <li class="footer-menu__li"><a href="" class="footer-menu__a">Поиск по сайту</a></li>
                                <li class="footer-menu__li"><a href="" class="footer-menu__a">Аккаунт PRO</a></li>
                                <li class="footer-menu__li"><a href="" class="footer-menu__a">Платные опции в проектах</a></li>
                                <li class="footer-menu__li"><a href="" class="footer-menu__a">Реклама на сайте</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="footer-menu">
                        <div class="footer-menu__name">О сайте</div>
                        <div class="footer-menu__uls">
                            <ul class="footer-menu__ul">
                                <li class="footer-menu__li"><a href="" class="footer-menu__a">Помощь</a></li>
                                <li class="footer-menu__li"><a href="" class="footer-menu__a">Правила</a></li>
                                <li class="footer-menu__li"><a href="" class="footer-menu__a">Команда</a></li>
                            </ul>
                        </div>
                    </div>

                </div>

            </div>

        </footer>
    </div>
</template>

<script>
    import VHeader from '../Header.vue'
    import VSidebar from '../components/Sidebar.vue';
    import VHeading from '../components/Heading.vue';

    export default {
        name: "MainLayout",
        components: {
            VHeader, VSidebar, VHeading
        },
    }
</script>