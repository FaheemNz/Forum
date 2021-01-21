let axios = require("axios");
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response.data.error) {
            flash(error.response.data.error.message, "alert-danger");
        } else if (error.response.data.errors) {
            let errorMessages = "";
            Object.values(error.response.data.errors).map(
                v => (errorMessages += v + "<br/>")
            );
            flash(errorMessages, "alert-danger");
        } else {
            flash("Some unexpected error occured!", "alert-warning");
        }

        return Promise.reject(error);
    }
);

export default axios;