export default {
    data(){
        return {
            items: []
        }
    },

    methods: {
        remove(index) {
            this.items.splice(index, 1);
            this.$emit("added");
            flash("Reply deleted!");
        },

        add(item) {
            this.items.push(item);
            this.$emit("removed");
        }
    }
};
