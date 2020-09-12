<template>
  <div>
    <div :key="reply.id" v-for="(reply, index) in items">
      <reply @deletereply="remove(index)" :data="reply"></reply>
    </div>

    <paginator @changed="fetchReplies" :dataSet="dataSet"></paginator>

    <new-reply @onnewreplycreated="add"></new-reply>
  </div>
</template>

<script>
import Reply from "./Reply.vue";
import NewReply from "./NewReply.vue";
import Collection from "../mixins/collection.js";

export default {
  components: { Reply, NewReply },

  mixins: [Collection],

  data() {
    return { dataSet: false };
  },

  created() {
    this.fetchReplies();
  },

  methods: {
    fetchReplies(page) {
      axios.get(this.url(page)).then((response) => {
        this.dataSet = response.data;
        this.items = response.data.data;
        window.scrollTo(0, 0);
      });
    },

    url(page) {
      // Handle direct Url
      if (!page) {
        let query = location.search.match(/page=(\d+)/);
        page = query ? query[1] : 1;
      }

      return `${location.pathname}/replies?page=${page}`;
    },
  },
};
</script>