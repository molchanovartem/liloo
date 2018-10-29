import {EVENT_DELETE} from "../eventCollection";

export const managerMixin = {
    created() {
        this.$on(EVENT_DELETE, () => {
            this.$notification.delete();
        });
    },
    data() {
        return {
            items: []
        };
    },
    methods: {
        getItemIndex(id) {
            return this.items.findIndex(item => {
                return +item.id === +id;
            });
        }
    }
};