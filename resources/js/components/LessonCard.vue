<template>
    <div class="lesson-card">
        <div class="lesson-title">{{ lesson.title }}</div>
        <div class="lesson-description">
            {{ lesson.description }}
        </div>
        <Button
            title="Take Lesson"
            icon="fas fa-edit"
            @click="$router.push({ name: 'lesson', params: { id: lesson.id } })"
            style="margin-right: 10px;"
        />
        <Button
            icon="fas fa-trash"
            v-if="showDelete"
            style="min-width: 50px; background: red; color: white; margin-right: 10px; border-color: red;"
            @click="deleteLesson(lesson.id)"
        />
        <FavoriteButton
            :lessonId="lesson.id"
            @removeLesson="$emit('removeLesson')"
        />
    </div>
</template>

<script>
import Button from "./Button";
import FavoriteButton from "./FavoriteButton.vue";

export default {
    components: { Button, FavoriteButton },
    props: {
        lesson: { type: Object, default: () => ({}) },
        showDelete: { type: Boolean, default: false }
    },
    methods: {
        async deleteLesson(lessonId) {
            const res = await axios.delete("/lessons/" + lessonId, {
                headers: {
                    Authorization:
                        "Bearer " + window.localStorage.getItem("access_token")
                }
            });
            if (res.data.success) {
                this.$emit("removeLesson");
                Vue.$toast.success("Lesson deleted successfully.");
            } else {
                Vue.$toast.error("Please enter");
            }
        }
    }
};
</script>

<style lang="scss" scoped>
.lesson-card {
    background: white;
    padding: 50px;
    margin-bottom: 20px;
    transition: 0.2s;
    border: 1px solid white;

    &:hover {
        border: 1px solid dodgerblue;
        background: rgb(225, 230, 247);
    }

    .lesson-title {
        font-size: 2em;
    }

    .lesson-description {
        margin: 10px 0;
        margin-bottom: 20px;
    }
}
</style>
