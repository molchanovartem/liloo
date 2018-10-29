import {MasterSettings} from "../settings/MasterSettings";

export default {
    install(Vue, options) {
        Vue.prototype.$settings = {
            master: new MasterSettings()
        };
    }
};