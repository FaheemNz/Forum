<template>
  <button type="button" :class="cssClasses" @click="toggleThreadSubscription">{{ btnText }}</button>
</template>

<script>
export default {
  props: ["active"],

  data() {
    return {
      isActive: this.active,
    };
  },

  computed: {
    cssClasses() {
      return ["btn", this.isActive ? "btn-primary" : "btn-default"];
    },

    btnText() {
      return this.isActive ? "Subscribed" : "Subscribe";
    },
  },

  methods: {
    toggleThreadSubscription() {
      let endPoint = location.pathname + "/subscriptions",
        requestType = this.isActive ? "delete" : "post";

      axios[requestType](endPoint).then((response) => {
        if (response.status === 201) {
          this.updateUI("Subscribed to the thread...");
        } else if (response.status === 202) {
          this.updateUI("UnSubscribed from the thread...");
        }
      });
    },

    updateUI(message) {
      this.isActive = !this.isActive;
      flash(message);
    },
  },
};
</script>