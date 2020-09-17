<template>
  <div class="card mb-4" :class="isBestReply ? 'is-best' : ''">
    <span v-if="isBestReply" class="badge badge-success best-reply-badge">Best Reply</span>

    <div class="card-header d-flex justify-content-between">
      <span>
        <a class="link" :href="'/profiles/' + reply.user.name">{{ reply.user.name }}</a>
        replied {{ reply.created_at }}
      </span>
      <favorite v-if="signedIn" :reply="reply"></favorite>
    </div>

    <div class="card-body">
      <div v-if="editing" class="form-group text-right">
        <form @submit.prevent="update">
          <textarea name="body" class="form-control" required v-model.trim="body" rows="6"></textarea>
          <div class="mt-3">
            <button type="button" class="btn" @click="editing = false">Cancel</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
      <div v-else v-html="body"></div>
    </div>

    <div class="card-footer justify-content-between d-flex align-items-center">
      <div v-if="authorize('can', reply)">
        <button
          @click="editing = !editing"
          type="button"
          title="Edit Reply"
          class="btn is-sm btn-floating bg-info ml-1"
        >
          <i class="fa fa-pencil"></i>
        </button>
        <button
          data-toggle="tooltip"
          title="Delete Reply"
          type="button"
          @click="deleteReply"
          class="btn btn-floating is-sm bg-cyan ml-1"
        >
          <i class="fa fa-trash"></i>
        </button>
      </div>

      <button
        data-toggle="tooltip"
        title="Mark Reply as Best"
        @click="setReplyAsBest"
        type="button"
        v-if="authorize('can', reply.thread)"
        class="btn is-sm btn-floating bg-success ml-1"
      >
        <i class="fa fa-check"></i>
      </button>
    </div>
  </div>
</template>

<script>
import Favorite from "./Favorite.vue";

export default {
  components: { Favorite },

  props: ["reply"],

  data() {
    return {
      editing: false,
      id: this.reply.id,
      body: this.reply.body,
      isBestReply: this.reply.isBest,
    };
  },

  computed: {
    canSetBestReply() {
      return true;
    },
  },

  created() {
    window.events.$on("onbestreplyselected", (bestReplyId) => {
      this.isBestReply = bestReplyId === this.id;
    });
  },

  methods: {
    update() {
      if (!this.body) return;

      axios
        .put(`/replies/${this.id}`, {
          body: this.body,
        })
        .then((response) => {
          response.status === 204 &&
            this.updateUI("Reply has been updated!", "alert-info");
        });

      this.editing = false;
    },

    deleteReply() {
      axios.delete(`/replies/${this.id}`).then((response) => {
        if (response.status === 204) {
          this.$emit("ondeletereply", this.id);
          this.updateUI("Reply has been deleted", "alert-info");
        }
      });
    },

    setReplyAsBest() {
      axios.post(`/replies/${this.id}/best`).then((response) => {
        response.status === 204 &&
          window.events.$emit("onbestreplyselected", this.id);
      });
    },

    updateUI(message, type) {
      flash(message, type);
    },
  },
};
</script>
