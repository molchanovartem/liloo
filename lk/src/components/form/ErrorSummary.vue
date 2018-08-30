<template>
    <div class="uk-margin">
        <div v-if="errorsItems.length > 0" class="uk-alert uk-alert-danger uk-text-small">
            <div v-for="error in errorsItems">{{error}}</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErrorSummary",
        props: ['errors'],
        computed: {
            errorsItems() {
                let items = [];

                if (this.errors !== undefined && this.errors !== null) {
                    Object.values(this.errors)
                        .forEach(item => {
                            item.forEach(value => {
                                items.push(value);
                            });
                        });
                }

                return items;
            }
        }
    }
</script>