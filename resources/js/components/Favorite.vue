<template>
    <button type="submit" :class="cssClasses" @click="toggleFavorite">
        <i class="fa fa-heart fa-xs"></i>
        <span v-text="count"></span>
    </button>
</template>

<script>
export default {
    props: ["reply"],

    data() {
        return {
            count: this.reply.favoritesCount,
            active: this.reply.isFavorited
        };
    },

    computed: {
        cssClasses() {
            return ["btn", this.active ? "btn-primary" : "btn-default"];
        },

        endPoint() {
            return `/replies/${this.reply.id}/favorites`;
        }
    },

    methods: {
        toggleFavorite() {
            this.active ? this.destroy() : this.create();
        },

        destroy() {
            axios
                .delete(`/replies/${this.reply.id}/favorites`)
                .then(response =>
                    this.updateFavoritesState(false, response.data.message)
                );
        },

        create() {
            axios
                .post(`/replies/${this.reply.id}/favorites`)
                .then(response =>
                    this.updateFavoritesState(true, response.data.message)
                );
        },

        updateFavoritesState(state, message) {
            this.active = state;
            state ? this.count++ : this.count--;
            flash(message);
        }
    }
};
</script>
