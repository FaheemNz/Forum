require("./bootstrap");

Vue.component("flash", require("./components/Flash.vue").default);
Vue.component("thread-view", require("./pages/Thread.vue").default);
Vue.component("paginator", require("./components/Paginator.vue").default);

$('[data-toggle="tooltip"]').tooltip();

const app = new Vue({
    el: "#app"
});