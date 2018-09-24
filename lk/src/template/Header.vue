<template>
    <header class="header">
        <div class="header__container">
            <div class="header__wrap content-width">
                <div class="header__wrap-part">

                    <a class="logo" href="/"><img
                            src="http://upload.wikimedia.org/wikipedia/commons/a/ab/Logo_TV_2015.png" alt="logo"
                            class="logo__img"></a>

                </div>
                <div class="header__wrap-part header__wrap-part_actions">
                    <a href="" class="choose-city">
                        <span class="choose-city__fa fas fa-map-marker-alt"></span>
                        <span class="choose-city__text">Москва</span>
                    </a>

                    <a href="" class="personal-avatar"
                       style="background-image: url(https://leonardo.osnova.io/c5591b46-aefc-5aa2-7be1-9ba41cef3ea0/);">
                        <span class="personal-avatar__notifications">2</span>
                    </a>

                    <a href="" @click.prevent="onLogout" class="font_Gilroy-17-800-000000">Выйти</a>

                </div>
                <div class="header__wrap-part header__wrap-part_actions">
                    <a href="tel:88002345533" class="button-phone">
                        <span class="button-phone__fa fas fa-phone fa-flip-horizontal"></span>
                        <span class="button-phone__text">8 800 234-55-33</span>
                    </a>
                    <div class="cloud-wrap">

                        <span class="button-hamburger">
                            <span class="button-hamburger__cross">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </span>

                        <div class="cloud cloud_in_header" style="display: none;">
                            <div class="cloud__content">

                                <div class="footer-menu">
                                    <div class="footer-menu__name">Специалисты</div>
                                    <div class="footer-menu__uls">
                                        <ul class="footer-menu__ul">
                                            <li class="footer-menu__li"><a href="" class="footer-menu__a">Косметолог</a>
                                            </li>
                                            <li class="footer-menu__li"><a href="" class="footer-menu__a">Визажист</a>
                                            </li>
                                            <li class="footer-menu__li"><a href="" class="footer-menu__a">Стилист</a>
                                            </li>
                                            <li class="footer-menu__li"><a href="" class="footer-menu__a">Фотограф</a>
                                            </li>
                                        </ul>
                                        <ul class="footer-menu__ul">
                                            <li class="footer-menu__li"><a href="" class="footer-menu__a">Косметолог</a>
                                            </li>
                                            <li class="footer-menu__li"><a href="" class="footer-menu__a">Визажист</a>
                                            </li>
                                            <li class="footer-menu__li"><a href="" class="footer-menu__a">Стилист</a>
                                            </li>
                                            <li class="footer-menu__li"><a href="" class="footer-menu__a">Брови,
                                                ресницы</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-width mb-40">
                <v-breadcrumbs/>
            </div>
        </div>
    </header>
</template>

<script>
    import VBreadcrumbs from './components/Breadcrumbs.vue';

    export default {
        name: "Header",
        components: {VBreadcrumbs},
        methods: {
            onLogout() {
                localStorage.setItem('authenticate', false);
                localStorage.setItem('token', null);
                this.$router.push({name: 'login'});
            }
        }
    }
</script>