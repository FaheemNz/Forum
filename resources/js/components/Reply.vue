<template>
  <div class="card mb-4">
    <div class="card-header d-flex justify-content-between">
      <span>
        <a :href="'/profiles/' + data.user.name">{{ data.user.name }}</a>
        replied {{ data.created_at }}
      </span>
      <favorite v-if="signedIn" :reply="data"></favorite>
    </div>
    <div class="card-body">
      <div v-if="editing" class="form-group text-right">
        <form @submit.prevent="update">
          <textarea name id class="form-control" required v-model.trim="body" rows="6"></textarea>
          <div class="mt-3">
            <button type="button" class="btn" @click="editing = false">Cancel</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
      <div v-else v-html="body"></div>
    </div>
    <div v-if="canUpdate" class="card-footer justify-content-end d-flex align-items-center">
      <button @click="editing = !editing" type="button" class="btn is-sm btn-floating bg-info ml-1">
        <i class="fa fa-pencil"></i>
      </button>
      <button type="button" @click="deleteReply" class="btn btn-floating is-sm bg-danger ml-1">
        <i class="fa fa-trash"></i>
      </button>
    </div>
  </div>
</template>

<script>
import Favorite from "./Favorite.vue";

export default {
  components: { Favorite },

  props: ["data"],

  data() {
    return {
      editing: false,
      id: this.data.id,
      body: this.data.body,
    };
  },

  computed: {
    signedIn() {
      return !window.App ? false : window.App.signedIn;
    },

    canUpdate() {
      return this.authorize((user) => user.id == this.data.user_id);
    },
  },

  methods: {
    update() {
      if (!this.body) return;

      axios
        .put("/replies/" + this.data.id, {
          body: this.body,
        })
        .then(
          (response) =>
            response.status === 204 &&
            this.updateUI("Reply has been updated!", "alert-info")
        );

      this.editing = false;
    },

    deleteReply() {
      axios.delete("/replies/" + this.data.id).then((response) => {
        if (response.status === 204) {
          this.updateUI("Reply has been deleted", "alert-info");
        }
      });
    },

    updateUI(message, type) {
      flash(message, type);
    },
  },
};
</script>
