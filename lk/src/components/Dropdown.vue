<template>
    <div>
        <button :class="buttonClass">{{buttonText}}
        </button>
        <div :data-uk-dropdown="dataUk">
            <ul :class="ulClass">
                <slot></slot>

                <li :class="itemClass(item.type)" v-for="item in items">
                        <span v-if="!item.url">
                            <i v-if="item.icon" :class="item.icon"></i>{{item.label}}
                        </span>
                    <router-link v-if="item.url" :to="item.url">
                        <i v-if="item.icon" :class="item.icon"></i>{{item.label}}
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Dropdown",
        props: {
            dataUk: {
                default: ''
            },
            items: {
                type: Array,
                default() {return []}
            },
            buttonText: {
                type: String,
                default: 'Button'
            },
            buttonClass: {
                type: String,
                default: 'uk-button uk-button-small uk-button-default'
            },
            ulClass: {
                type: String,
                default: 'uk-nav uk-dropdown-nav'
            },
            itemActiveClass: {
                type: String,
                default: 'uk-active'
            },
            itemHeaderClass: {
                type: String,
                default: 'uk-nav-header'
            },
            itemDividerClass: {
                type: String,
                default: 'uk-nav-divider'
            }
        },
        methods: {
            itemClass(type = null) {
                switch (type) {
                    case 'divider':
                        return this.itemDividerClass;
                    case 'header':
                        return this.itemHeaderClass;
                    default:
                        return null;
                }
            }
        }
    }
</script>