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

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.Vue = require("vue");

Vue.prototype.authorize = function(handler) {
    let user = window.App && window.App.signedIn;
    return user ? handler(user) : false;
};

window.events = new Vue();
window.flash = (message, type = null) =>
    window.events.$emit("flash", message, type);

window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

window.axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response.data.error.message) {
            flash(error.response.data.error.message, "alert-danger");
        } else if (error.response.data.error.errors) {
            let allErrors = Object.values(error.response.data.error.errors);
            allErrors.map(value => {
                flash(value, "alert-danger");
            });
        }
        // } else if (error.response.data.message) {
        //     console.log("Ok!");
        //     flash(error.response.data.error.message);
        // } else {
        //     flash("Some error occured!");
        // }
    }
);
