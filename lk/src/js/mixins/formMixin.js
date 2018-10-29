import {EVENT_SAVE} from "../eventCollection";

export const formMixin = {
    created() {
        this.$on(EVENT_SAVE, () => {
            this.$notification.save();
        });
    }
};

