<template>
  <aside class="alert shadow" role="alert" v-show="show">
    <div>
      <strong>Alert!</strong>
      {{ body }}
    </div>
  </aside>
</template>

<script>
export default {
  props: ["message"],
  data() {
    return {
      show: false,
      body: "",
    };
  },

  created() {
    if (this.message) {
      this.flash();
    }

    window.events.$on("flash", (message) => this.flash(message));
  },

  methods: {
    flash(message) {
      this.show = true;
      this.body = message;

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