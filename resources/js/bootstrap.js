import Vue from "vue";
import Popper from "popper.js";
import JQuery from "jquery";
import bootstrap from "bootstrap";
import axios from "./bootAxios.js";

window.Popper = Popper;
window.$ = JQuery;
window.Vue = Vue;
window.axios = axios;

import { getLoggedInUser } from "./utils/getLoggedInUser.js";
import authorizations from "./authorizations.js";
import InstantSearch from "vue-instantsearch";

Vue.use(InstantSearch);

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
