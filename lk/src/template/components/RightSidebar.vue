<template>
    <v-navigation-drawer
            v-model="show"
            absolute
            temporary
            width="500"
            right
    >
        <v-tabs v-model="tabActive" dark>
            <v-tab key="1" ripple>Настройки</v-tab>
            <v-tab key="2" ripple>Справка</v-tab>
            <v-tab-item>
                <v-card flat>
                    <v-card-text>текст</v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item>
                <v-card flat>
                    <v-card-text>
                        <iframe :src="documentationHref" width="100%" height="800px"
                                frameborder="0"></iframe>
                    </v-card-text>
                </v-card>
            </v-tab-item>
        </v-tabs>
    </v-navigation-drawer>
</template>

<script>
    export default {
        name: "RightSidebar",
        data() {
            return {
                show: false,
                tabActive: '1',
                documentationHref: null
            }
        },
        watch: {
            show() {

            },
            '$store.state.rightSidebar.show': function (value) {
                this.show = value;
            },
            '$store.state.rightSidebar.tabActive': function (value) {
                this.tabActive = value;
            },
            '$store.state.rightSidebar.documentationHref': function (value) {
                this.documentationHref = value;
            }
        }
    }
</script>