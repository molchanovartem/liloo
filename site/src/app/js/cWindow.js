var cWindow = {
    TYPE_BIG: 'big',
    TYPE_NORMAL: 'normal',
    TYPE_SMALL: 'small',
    TYPE_BIG_MODAL: 'bigModal',
    TYPE_NORMAL_MODAL: 'normalModal',
    TYPE_SMALL_MODAL: 'smallModal',

    _windows: {big: null, normal: null, small: null, bigModal: null, normalModal: null, smallModal: null},

    destroy: function (type) {
        var window = this.getWindowByType(type);

        window.dialog('destroy');
        if (this._windows[type] !== undefined) {
            this._windows[type] = null;
        } else {
            throw new Error('No window: ' + type);
        }
    },

    getWindowByType: function (type) {
        switch (type) {
            case this.TYPE_BIG :
                return this.big();
            case this.TYPE_NORMAL :
                return this.normal();
            case this.TYPE_SMALL :
                return this.small();
            case this.TYPE_BIG_MODAL :
                return this.bigModal();
            case this.TYPE_NORMAL_MODAL :
                return this.normalModal();
            case this.TYPE_SMALL_MODAL :
                return this.smallModal();
            default :
                throw new Error('No exist type window');
        }
    },

    big: function () {
        if (this._windows.big === null) {
            this._windows.big = $('<div></div>').dialog({
                autoOpen: false,
                minWidth: 1200,
                maxWidth: 1200
            });
        }
        return this._windows.big;
    },

    normal: function () {
        if (this._windows.normal === null) {
            this._windows.normal = $('<div></div>').dialog({
                autoOpen: false,
                minWidth: 900,
                maxWidth: 900
            });
        }
        return this._windows.normal;
    },

    small: function () {
        if (this._windows.small === null) {
            this._windows.small = $('<div></div>').dialog({
                autoOpen: false,
                minWidth: 600,
                maxWidth: 600
            });
        }
        return this._windows.small;
    },

    bigModal: function () {
        if (this._windows.bigModal === null) {
            this._windows.bigModal = $('<div></div>').dialog({
                autoOpen: false,
                modal: true,
                minWidth: 1200,
                maxWidth: 1200
            });
        }
        return this._windows.bigModal;
    },

    normalModal: function () {
        if (this._windows.normalModal === null) {
            this._windows.normalModal = $('<div></div>').dialog({
                autoOpen: false,
                modal: true,
                minWidth: 900,
                maxWidth: 900
            });
        }
        return this._windows.normalModal;
    },

    smallModal: function () {
        if (this._windows.smallModal === null) {
            this._windows.smallModal = $('<div></div>').dialog({
                autoOpen: false,
                modal: true,
                minWidth: 600,
                maxWidth: 600
            });
        }
        return this._windows.smallModal;
    }
};