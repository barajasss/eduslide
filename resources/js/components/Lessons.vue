<template>
    <div>
        <div class="lesson-title">{{ title }}</div>
        <div v-for="(lesson, i) in lessons" :key="i">
            <LessonCard :lesson="lesson" :showDelete="myLessons" />
        </div>
        <Paginator
            :totalResults="30"
            :page="page"
            @update="handlePaginatorUpdate"
        />
    </div>
</template>

<script>
import LessonCard from "./LessonCard";
import Paginator from "./Paginator";

export default {
    props: {
        title: { type: String, default: "Lessons" },
        myLessons: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            lessons: [],
            page: 1
        };
    },
    components: { LessonCard, Paginator },
    async mounted() {
        await this.fetchLessons();
    },
    methods: {
        async fetchLessons() {
            const res = await axios.get("/lessons");
            this.lessons = res.data;
        },
        handlePaginatorUpdate(data) {
            const { page } = data;
            this.page = page;
        }
    }
};
</script>

<style lang="scss" scoped>
.lesson-title {
    font-size: 2em;
    margin: 20px 0;
}
</style>
