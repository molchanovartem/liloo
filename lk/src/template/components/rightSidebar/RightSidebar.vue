<template>
    <div>
        <v-navigation-drawer
                v-model="show"
                temporary
                width="500"
                right
                fixed
        >
            <v-tabs v-model="tabActive" dark>
                <v-tab key="0" ripple>Настройки</v-tab>
                <v-tab key="1" ripple>Справка</v-tab>
                <v-tab-item key="0">
                    <v-card flat>
                        <v-card-text>текст</v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item key="1">
                    <v-card flat>
                        <v-card-text>
                            <iframe :src="documentationHref" width="100%" height="800px"
                                    frameborder="0"></iframe>
                        </v-card-text>
                    </v-card>
                </v-tab-item>
            </v-tabs>
        </v-navigation-drawer>
    </div>
</template>

<script>
    import {rightSidebarService} from "./sidebarService";

    export default {
        name: "RightSidebar",
        created() {
            rightSidebarService.$on('show', () => {
                this.show = true;
            });
            rightSidebarService.$on('show:documentation', (href) => {
                this.show = true;
                this.tabActive = 1;
                this.documentationHref = href;
            });
        },
        data() {
            return {
                show: false,
                tabActive: 0,
                documentationHref: null
            }
        },
    }
</script>