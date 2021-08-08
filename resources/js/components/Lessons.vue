<template>
    <div>
        <div class="lesson-title">{{ title }}</div>
        <div class="page-info" v-if="totalPages > 1">
            Page {{ page }} of {{ totalPages }}
        </div>
        <template v-if="!isLoading && !lessons.length">
            <div v-if="myLessons">
                You have not created any lessons yet.
            </div>
            <div v-else-if="favorites">
                You have not marked any lesson as favorite.
            </div>
        </template>

        <div v-for="(lesson, i) in lessons" :key="i">
            <LessonCard
                :lesson="lesson"
                :showDelete="myLessons"
                :showEdit="myLessons"
                @updateLessons="updateLessons"
            />
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
        },
        favorites: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            lessons: [],
            page: 0,
            itemsPerPage: 3,
            totalResults: 0,
            totalPages: 0,
            isLoading: false
        };
    },
    components: { LessonCard, Paginator },
    async mounted() {},
    watch: {
        page(e) {
            window.scrollTo({ top: 0 });
            this.fetchLessons();
        }
    },
    methods: {
        async updateLessons() {
            await this.fetchLessons();
        },
        async fetchLessons() {
            this.isLoading = true;
            let url = `/lessons?page=${this.page}&limit=${this.itemsPerPage}`;
            if (this.favorites) {
                url += "&favorites=true";
            }
            if (this.myLessons) {
                url += "&my_lessons=true";
            }
            try {
                const res = await axios.get(url);
                this.lessons = res.data.lessons;
                this.totalResults = res.data.totalResults;
            } catch (err) {
                console.log("Error in loading lessons");
            }
            this.isLoading = true;
        },
        handlePaginatorUpdate(data) {
            const { page, totalPages } = data;
            if (page) {
                this.page = page;
            }
            if (totalPages) {
                this.totalPages = totalPages;
            }
        }
    }
};
</script>

<style lang="scss" scoped>
.lesson-title {
    font-size: 2em;
    margin: 20px 0;
}
.page-info {
    margin-bottom: 15px;
}
</style>
