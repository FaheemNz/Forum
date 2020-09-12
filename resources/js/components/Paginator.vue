<template>
  <ul class="pagination justify-content-end" v-if="showPagination">
    <li class="page-item" v-show="prevUrl">
      <a @click.prevent="page--" rel="prev" class="page-link" href="#" aria-label="Previous">
        <span aria-hidden="true">
          <i class="fa fa-chevron-left mr-2"></i> Previous
        </span>
      </a>
    </li>
    <li class="page-item" v-show="nextUrl">
      <a disabled @click.prevent="page++" rel="next" class="page-link" href="#" aria-label="Next">
        <span aria-hidden="true">
          Next
          <i class="fa fa-chevron-right ml-2"></i>
        </span>
      </a>
    </li>
  </ul>
</template>

<script>
export default {
  props: ["dataSet"],

  data() {
    return {
      page: 1,
      prevUrl: false,
      nextUrl: false,
    };
  },

  watch: {
    dataSet() {
      this.page = this.dataSet.current_page;
      this.prevUrl = this.dataSet.prev_page_url;
      this.nextUrl = this.dataSet.next_page_url;
    },

    page() {
      this.broadcast().updateUrl();
    },
  },

  computed: {
    showPagination() {
      return !!this.prevUrl || !!this.nextUrl;
    },
  },

  methods: {
    broadcast() {
      this.$emit("changed", this.page, this.isAjaxing);
      return this;
    },

    updateUrl() {
      history.pushState(null, null, "?page=" + this.page);
    },
  },
};
</script>