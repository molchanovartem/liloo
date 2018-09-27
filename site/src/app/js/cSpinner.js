var cSpinner = {
    el: null,
    init() {
      this.el = document.getElementById('appSpinner');
    },

    show() {
        this.el.style.display = 'block';
    },
    hide() {
        this.el.style.display = 'none';
    },
};