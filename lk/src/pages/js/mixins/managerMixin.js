import {EVENT_DELETE} from "../../../js/eventCollection";

export const managerMixin = {
    created() {
        this.$on(EVENT_DELETE, () => {
            this.$notification.delete();
        });
    },
    data() {
        return {
            pagination: {
                page: 1
            },
            rowsPerPage: 2,
            items: [],
            total: 0
        };
    },
    methods: {
        getOffset() {
            let page = this.pagination.page;
            return page === 1 ? 0 : (page - 1) * this.rowsPerPage;
        },
        getItemIndex(id) {
            return this.items.findIndex(item => {
                return +item.id === +id;
            });
        },
    }
};