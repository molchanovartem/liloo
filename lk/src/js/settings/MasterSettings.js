import {Settings} from './Settings';

export class MasterSettings extends Settings {

    getWorkTime() {
        return this.getData('workTime');
    }

    setWorkTime(value) {
        this.setData('workTime', value);
    }

    getData(name) {
        let settings = localStorage.getItem('settings');

        if (settings === null) return null;
        else settings = JSON.parse(settings);

        return settings.master[name] || null;
    }

    setData(name, data) {
        let settings = localStorage.getItem('settings');

        if (settings === null) {
            settings = {master: {}};
        } else {
            settings = JSON.parse(settings);
        }

        settings.master[name] = data;

        localStorage.setItem('settings', JSON.stringify(settings));
    }
}