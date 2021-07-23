<template>
    <div>
        <div class="lessons-title">Available Lessons</div>
        <Lesson v-for="i of 10" :key="i" />
    </div>
</template>

<script>
import Lesson from "./LessonCard.vue";
export default {
    components: { Lesson }
};
</script>

<style lang="scss" scoped>
.lessons-title {
    font-size: 1.5em;
    margin-bottom: 30px;
    border-bottom: 2px solid rgb(113, 181, 250);
}
</style>
