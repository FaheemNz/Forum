<template>
  <div>
    <form v-if="canUpdate" enctype="multipart/form-formData" method="POST">
      <image-upload @onfileuploadcomplete="persistAvatar" />
    </form>
    <img class="avatar" :src="avatarSrc" />
  </div>
</template>

<script>
import ImageUpload from "./ImageUpload.vue";

export default {
  props: ["user", "route"],

  components: { ImageUpload },

  data() {
    return {
      avatarSrc: this.user.avatar_path,
    };
  },

  computed: {
    canUpdate() {
      return this.authorize((authUser) => authUser.id === this.user.id);
    },
  },

  methods: {
    async persistAvatar(avatarObj) {
      let formData = new FormData();
      formData.append("avatar", avatarObj.file);
      const response = await axios.post(this.route, formData);
      response.status === 204 && this.updateUI(avatarObj.src);
    },

    updateUI(src) {
      this.avatarSrc = src;
      flash("Your Avatar has been updated", "alert-success");
    },
  },
};
</script>