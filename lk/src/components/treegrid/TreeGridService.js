export const TREE_GRID_SERVICE = {
    events: {},
    groupAttribute: null,
    rowsGroupSelected: {},
    rowsItemSelected: {},
    singleSelected: false,

    init() {
        this.clearEvents();
    },

    isRowGroup(row) {
        return true;
    },
    isRowItem(row) {
        return true;
    },
    hasRowGroupSelected(row) {
        return this.rowsGroupSelected[row.id] !== undefined;
    },
    hasRowItemSelected(row) {
        return this.rowsItemSelected[row.id] !== undefined;
    },
    addRowSelected(row) {
        if (this.isRowGroup(row)) {
            this.addGroupSelected(row);
        }

        if (this.isRowItem(row)) {
            this.addIteSelected(row);
        }
    },
    addGroupSelected(row) {
        let id = row.id;

        if (!this.rowsGroupSelected[id]) {
            this.rowsGroupSelected[id] = 'selected';
        }
    },
    addIteSelected(row) {
        let id = row.id;

        if (!this.rowsItemSelected[id]) {
            this.rowsItemSelected[id] = 'selected';
        }
    },

    canSelected(row) {
        this.deleteRowSelected(row);

        if (!this.singleSelected) return true;

        console.log(this.hasRowGroupSelected(row));

        if (this.isRowGroup(row) && !this.hasRowGroupSelected(row)) {
            let ar = this.getGroupSelected();

            console.log( ar.length < 2);

            return ar.length < 2;
        }

        if (this.isRowItem(row) && !this.hasRowItemSelected) {
            let ar = this.getGroupSelected();

            return ar.length < 2;
        }

        return this.isRowGroup(row) ? !this.hasRowGroupSelected(row) : !this.hasRowItemSelected(row);
     },

    deleteRowSelected(row) {
        return this.isRowGroup(row) ? this.deleteRowGroupSelected(row) : this.deleteRowItemSelected(row);
    },

    deleteRowGroupSelected(row) {
        if (this.hasRowGroupSelected(row)) {
            delete this.rowsGroupSelected[row.id];
            return true;
        }
        return false;
    },

    deleteRowItemSelected(row) {
        if (this.hasRowItemSelected(row)) {
            delete this.rowsItemSelected[row.id];
            return true;
        }
        return false;
    },

    getGroupSelected() {
        return Object.keys(this.rowsGroupSelected);
    },
    getItemSelected() {
        return Object.keys(this.rowsItemSelected);
    },

    emit(eventName, data) {
        let event = this.events[eventName];

        if (event) {
            event.forEach(fn => {
                fn(data);
            });
        }
    },

    on(eventName, fn) {
        if (!this.events[eventName]) {
            this.events[eventName] = [];
        }

        this.events[eventName].push(fn);
    },

    clearEvents() {
        this.events = {};
    }
};