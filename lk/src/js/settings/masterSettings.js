export const masterSettings = {
    getWorkTime() {
        return this.getData('time');
    },

    setWorkTime(time) {
        this.setData('time', time);
    },

    getData(name)
    {
      return localStorage.getItem(this.getKey(name));
    },

    setData(name, data) {
        localStorage.setItem(this.getKey(name), data);
    },

    getKey(name) {
        return 'master:' . name;
    },
};