require("./bootstrap");

Vue.component("flash", require("./components/Flash.vue").default);
Vue.component("thread-view", require("./pages/Thread.vue").default);
Vue.component("paginator", require("./components/Paginator.vue").default);
Vue.component("user-notifications", require("./components/UserNotifications.vue").default);

$(document).ready(function(){
    $('.scroll-top').click(() => window.scrollTo(0, 0));
    $('[data-toggle="tooltip"]').tooltip();
});

const app = new Vue({
    el: "#app"
});