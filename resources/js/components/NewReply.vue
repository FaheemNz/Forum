<template>
  <div class="mt-4 mb-4">
    <div v-if="signedIn">
      <div class="form-group">
        <textarea
          placeholder="Leave a Reply"
          v-model="body"
          name="body"
          class="form-control"
          rows="5"
        ></textarea>
      </div>
      <div class="form-group text-right">
        <button type="submit" class="btn btn-primary" @click="addReply">Add Reply</button>
      </div>
    </div>
    <p v-else class="text-center">
      <i class="fa fa-lock mr-2"></i> Sign in to take part in discussion...
    </p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      body: "",
    };
  },

  computed: {
    signedIn() {
      return window.App && window.App.signedIn;
    },
  },

  methods: {
    addReply() {
      if (!this.body.trim()) return;

      let endPoint = location.pathname + '/replies';

      axios.post(endPoint, { body: this.body }).then((response) => {
        this.body = "";
        flash("Reply added!");
        this.$emit("onnewreplycreated", response.data);
      });
    },
  },
};
</script>