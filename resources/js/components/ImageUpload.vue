<template>
  <input accept="image/*" type="file" @change="onChange" />
</template>

<script>
export default {
  methods: {
    onChange(e) {
      if (!e.target.files.length) return;

      let file = e.target.files[0],
        reader = new FileReader();

      reader.readAsDataURL(file);

      reader.onload = (e) => {
        let src = e.target.result;
        this.$emit("onfileuploadcomplete", { src, file });
      };
    },
  },
};
</script>