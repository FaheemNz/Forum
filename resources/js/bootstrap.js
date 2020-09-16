/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require("popper.js").default;
    window.$ = window.jQuery = require("jquery");

    require("bootstrap");
} catch (e) {}

window.Vue = require("vue");

import authorizations from "./authorizations.js";
import axios from "./bootAxios.js";
import { getLoggedInUser } from "./utils/getLoggedInUser.js";

window.axios = axios;

Vue.prototype.authorize = function(...params) {
    let user = getLoggedInUser();

    if (!user) return;

    if (typeof params[0] === "string") {
        return authorizations[params[0]](params[1]);
    }

    return params[0](user);
};

Vue.prototype.signedIn = !!getLoggedInUser();

window.events = new Vue();
window.flash = (message, type = null) =>
    window.events.$emit("flash", message, type);
