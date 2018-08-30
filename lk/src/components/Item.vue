<template>
    <div v-if="open">
        <tr>
            <td @click="onClick()">
                <span v-if="isGroup()">
                    isGroup
                </span>
                <span>
                    {{row.name | test(depth)}}
                </span>
            </td>
            <td>
                {{row.id}}
            </td>
        </tr>
        <item
                :row="row"
                :index="index"
                v-for="(row, index) in child"
                :open="isOpen"
                :depth="increaseDepth()"
        ></item>
    </div>
</template>

<script>
    import {HTTP} from "../js/http";

    export default {
        name: "Item",
        props: {
            row: {
                type: Object,
                required: true
            },
            open: {
                type: Boolean,
                default: false
            },
            depth: {
                type: Number,
                default: 0
            }
        },
        data() {
            return {
                group: false,
                openGroup: false,
                child: []
            }
        },
        methods: {
            isGroup() {
                return this.row.is_group !== undefined && this.row.is_group;
            },
            onClick() {
                if (!this.isOpen) {
                    HTTP.get('data/index')
                        .then((response) => {
                            this.child = response.data;
                            this.isOpen = true;
                        });
                } else {
                    this.isOpen = false;
                    this.child = [];
                }
            },
            increaseDepth() {
                return this.depth + 1;
            }
        },
        filters: {
            test(value, depth) {
                return '-'.repeat(depth) +  value
            }
        }
    }
</script>