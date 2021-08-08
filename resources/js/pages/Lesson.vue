<template>
    <div class="lesson-container">
        <div class="lesson-info">
            <div class="lesson-title">{{ lesson.title }}</div>
            <Button title="Present Slide" @click="presentSlide" />
            <div class="lesson-description">
                {{ lesson.description }}
            </div>
            <div class="d-flex">
                <FavoriteButton :lessonId="Number($route.params.id)" />
                <div style="margin-left: 20px;">
                    <div class="lesson-date">
                        Posted on
                        {{ new Date(lesson.created_at).toDateString() }}
                    </div>
                    <div class="lesson-author">By {{ lesson.user.name }}</div>
                </div>
            </div>
        </div>

        <div class="lesson-view">
            <SlideList ref="slideList" :lessonId="Number($route.params.id)" />
        </div>
    </div>
</template>

<script>
import SlideList from "../components/SlideList";
import FavoriteButton from "../components/FavoriteButton";
import Button from "../components/Button.vue";

export default {
    components: { SlideList, FavoriteButton, Button },
    data() {
        return {
            lesson: {}
        };
    },
    async mounted() {
        await this.getLesson();
    },
    methods: {
        async getLesson() {
            const res = await axios.get("/lessons/" + this.$route.params.id);
            this.lesson = res.data;
        },
        presentSlide() {
            this.$refs.slideList.enableFullScreen();
        }
    }
};
</script>

<style lang="scss" scoped>
.lesson-container {
    display: grid;
    grid-template-columns: 4fr 9fr;
    grid-gap: 35px;
}
.lesson-title {
    font-size: 2em;
}
.lesson-description {
    margin: 20px 0;
}
.lesson-info,
.lesson-view {
    flex: 1;
}
.lesson-view {
    min-height: 500px;
}
.lesson-date,
.lesson-author {
    color: #778;
    font-size: 0.9em;
}

@media screen and (max-width: 576px) {
    .lesson-container {
        grid-template-columns: 1fr;
    }
    .lesson-view {
        min-height: 350px;
    }
}
</style>
