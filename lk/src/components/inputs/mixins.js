export default {
    props: {
        attribute: {
            type: String
        },
        label: {
            type: String
        },
        value: null,
        errors: null
    },
    computed: {
        error() {
            if (this.errors === undefined) return '';
            if (this.errors === null) return '';

            if (this.errors[this.attribute] !== undefined) return this.errors[this.attribute].join(', ');
        }
    }
}