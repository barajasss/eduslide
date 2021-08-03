<template>
    <Button
        v-if="authenticated && user && loadedFav"
        :icon="`${isFav ? 'fas' : 'far'} fa-heart`"
        inverted
        :class="['fav-btn', { isFav }]"
        @click="toggleFav"
    />
</template>

<script>
import Button from "./Button.vue";
import { mapState, mapActions } from "vuex";

const headers = () => ({
    headers: {
        Authorization: "Bearer " + window.localStorage.getItem("access_token")
    }
});
export default {
    computed: {
        ...mapState("auth", ["authenticated", "user"])
    },
    props: {
        lessonId: {
            type: Number
        }
    },
    components: { Button },
    emits: ["removeLesson"],
    data() {
        return {
            isFav: false,
            loadedFav: false,
            favorite: null
        };
    },
    watch: {
        user(e) {
            if (e) {
                this.loadFav();
            }
        }
    },
    async mounted() {
        if (this.user) {
            this.loadFav();
        }
    },
    methods: {
        async loadFav() {
            try {
                const res = await axios.get(
                    `/favorites?user_id=${this.user &&
                        this.user.id}&lesson_id=${this.lessonId}`,
                    headers()
                );
                if (res.data && res.data.length) {
                    this.favorite = res.data[0];
                    this.isFav = true;
                } else {
                    this.favorite = res.data;
                    this.isFav = false;
                }
            } catch (err) {}
            this.loadedFav = true;
        },
        async toggleFav() {
            if (this.isFav) {
                // remove fav
                const res = await axios.delete(
                    "/favorites/" + this.favorite.id,
                    headers()
                );
                if (res.data.success) {
                    this.favorite = null;
                    this.isFav = false;
                    Vue.$toast.success("Lesson removed from favorites.");
                    this.$emit("removeLesson");
                } else {
                    Vue.$toast.error("Could not remove favorite.");
                }
            } else {
                // add fav
                const res = await axios.post(
                    "/favorites",
                    { lesson_id: this.lessonId },
                    headers()
                );
                if (res.data.id) {
                    this.favorite = res.data;
                    this.isFav = true;
                    Vue.$toast.success("Lesson marked as favorite.");
                } else {
                    Vue.$toast.error("Could not mark lesson as favorite.");
                }
            }
        }
    }
};
</script>

<style lang="scss" scoped>
.fav-btn {
    min-width: 50px;
    color: black;

    &.isFav {
        border-color: red;
        background: red;
        color: white;
        &:hover {
            // color: red;
        }
    }
    &:hover {
        background: red !important;
        border-color: red;

        &.isFav {
            background: white;
        }
    }
}
</style>
