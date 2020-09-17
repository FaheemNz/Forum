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
    };
  },

  computed: {
    lockBtnText() {
      return this.isLocked ? "UnLock" : "Lock";
    },
  },
  
  created(){
    console.log(this.isLocked)
  },

  methods: {
    toggleThreadLock() {
      axios
        .put(`/threads/${this.thread.slug}/lock`, { is_locked: !this.isLocked })
        .then((response) => {
          response.status === 204 && this.updateUI();
        });
    },

    updateUI() {
      this.isLocked = !this.isLocked;
      flash(
        `Thread has been ${this.isLocked ? "locked." : "unlocked."}`,
        "alert-info"
      );
    },
  },
};
</script>