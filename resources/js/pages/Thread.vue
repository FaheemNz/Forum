<script>
import Replies from "../components/Replies.vue";
import SubscribeButton from "../components/SubscribeButton.vue";

export default {
  components: { Replies, SubscribeButton },

  props: ["thread"],

  data() {
    return {
      repliesCount: this.thread.replies_count,
      isLocked: this.thread.is_locked,
      editing: false,
      title: this.thread.title,
      body: this.thread.body,
      form: {
        title: this.thread.title,
        body: this.thread.body,
      },
    };
  },

  computed: {
    lockBtnText() {
      return this.isLocked ? "UnLock" : "Lock";
    },
  },

  methods: {
    toggleThreadLock() {
      axios
        .put(`/threads/${this.thread.slug}/lock`, { is_locked: !this.isLocked })
        .then((response) => {
          if (response.status === 204) {
            this.isLocked = !this.isLocked;
            this.updateUI(
              `Thread has been ${this.isLocked ? "locked." : "unlocked."}`,
              "alert-info"
            );
          }
        });
    },

    updateThread() {
      let params = { ...this.form, channel_id: this.thread.channel_id };
      axios
        .put(`/threads/${this.thread.channel.slug}/${this.thread.slug}`, params)
        .then(
          (response) => response.status === 204 && this.onThreadUpdateComplete()
        );
    },

    onThreadUpdateComplete() {
      this.editing = false;
      this.title = this.form.title;
      this.body = this.form.body;
      this.updateUI("Thread has been Updated!", "alert-success");
    },

    updateUI(message, type) {
      flash(message, type);
    },
  },
};
</script>