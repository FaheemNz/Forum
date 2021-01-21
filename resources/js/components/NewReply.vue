<template>
  <div class="mt-5 mb-4">
    <form @submit.prevent="addReply" v-if="signedIn">
      <div class="form-group">
        <textarea
          placeholder="Leave a Reply"
          v-model.trim="body"
          required
          name="body"
          class="form-control"
          rows="5"
        ></textarea>
      </div>
      <div class="form-group text-right">
        <button type="submit" class="btn btn-primary">Add Reply</button>
      </div>
    </form>
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

  methods: {
    addReply() {
      if (!this.body) {
        flash("Invalid Reply!", "alert-danger");
        return;
      }

      let endPoint = location.pathname + "/replies";

      axios.post(endPoint, { body: this.body }).then((response) => {
        if (!response) return;
        this.onAddNewReply(response);
      });
    },

    onAddNewReply(response) {
      this.body = "";
      this.$emit("onnewreplycreated", response.data);
      flash("New reply has been created", "alert-success");
    },
  },
};
</script>