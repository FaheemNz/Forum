<template>
  <aside class="alert shadow" :class="alertTypeClass" role="alert" v-show="show">
    <div v-html="body">
    </div>
  </aside>
</template>

<script>
export default {
  props: ["message", "type"],

  data() {
    return {
      show: false,
      body: "",
      alertTypeClass: ""
    };
  },

  created() {
    if (this.message) {
      this.flash();
    }

    window.events.$on("flash", (message, type = null) =>
      this.flash(message, type)
    );
  },

  methods: {
    flash(message, type) {
      this.show = true;
      this.body = message;
      this.alertTypeClass = type;

      this.hide();
    },

    hide() {
      const id = setTimeout(() => {
        this.show = false;
        window.clearTimeout(id);
      }, 3000);
    },
  },
};
</script>