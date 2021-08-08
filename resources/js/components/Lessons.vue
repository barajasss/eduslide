<template>
    <div>
        <div class="lesson-title">{{ title }}</div>
        <div v-for="(lesson, i) in lessons" :key="i">
            <LessonCard :lesson="lesson" :showDelete="myLessons" />
        </div>
        <Paginator
            :totalResults="totalResults"
            :page="page"
            :itemsPerPage="itemsPerPage"
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
            page: 1,
            itemsPerPage: 3,
            totalResults: 0
        };
    },
    components: { LessonCard, Paginator },
    async mounted() {
        if (this.$route.query.page) {
            this.page = Number(this.$route.query.page);
        }

        if (this.page === 1) {
            await this.fetchLessons();
        }
    },
    watch: {
        page(e) {
            this.fetchLessons();
        }
    },
    methods: {
        async fetchLessons() {
            const res = await axios.get(
                `/lessons?page=${this.page}&limit=${this.itemsPerPage}`
            );
            this.lessons = res.data.lessons;
            this.totalResults = res.data.totalResults;
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
