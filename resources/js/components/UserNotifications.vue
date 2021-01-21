<template>
  <li class="dropdown" v-if="notifications.length">
    <a
      class="nav-link notification position-relative dropdown-toggle"
      href="#"
      role="button"
      data-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
    >
      <i class="fa fa-bell"></i>
      <span class="badge badge-danger badge-notification">{{ notifications.length }}</span>
    </a>
    <ul class="dropdown-menu shadow dropdown-menu-right">
      <li class="dropdown-item" v-for="(notification, i) in notifications" :key="i">
        <a
          class="is-link"
          @click="markNotificationAsRead(notification.id)"
          :href="notification.data.link"
          v-text="notification.data.message"
        ></a>
      </li>
    </ul>
  </li>
</template>

<script>
export default {
  data() {
    return {
      notifications: false,
    };
  },

  created() {
    this.fetchNotifications();
  },

  methods: {
    fetchNotifications() {
      axios
        .get(`/profiles/${window.App.user.name}/notifications`)
        .then((response) => {
          this.notifications = response.data;
        });
    },

    markNotificationAsRead(id) {
      axios
        .delete(`/profiles/${window.App.user.name}/notifications/${id}`)
        .then((response) => {
          console.log("Done...");
        });
    },
  },
};
</script>