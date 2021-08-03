<template>
    <div class="slide-list">
        <div class="slide-view">
            <Slide
                :title="currentSlide.title"
                :content="currentSlide.content"
                :number="index + 1"
                :totalSlides="slides.length"
                :showIndex="slides.length > 1"
            />
            <template v-if="slides.length > 1">
                <div
                    :class="['left-arrow', { disabled: index === 0 }]"
                    @click="updateIndex(index - 1)"
                >
                    <i class="fas fa-chevron-left" />
                </div>
                <div
                    :class="[
                        'right-arrow',
                        { disabled: index === slides.length - 1 }
                    ]"
                    @click="updateIndex(index + 1)"
                >
                    <i class="fas fa-chevron-right" />
                </div>
            </template>
        </div>
    </div>
</template>

<script>
import Slide from "./Slide.vue";
export default {
    props: {
        lessonId: { type: Number }
    },
    components: { Slide },
    data() {
        return {
            slides: [],
            index: 0,
            currentSlide: {
                title: "",
                content: ""
            }
        };
    },
    async mounted() {
        await this.getSlides(this.lessonId);
        this.index = 0;
        this.currentSlide = this.slides[this.index];
    },
    watch: {
        index(e) {
            this.currentSlide = this.slides[e];
        }
    },
    methods: {
        async getSlides(lessonId) {
            const res = await axios.get("/slides?lesson_id=" + lessonId);
            this.slides = res.data;
        },
        updateIndex(index) {
            if (index >= 0 && index < this.slides.length) {
                this.index = index;
            }
        }
    }
};
</script>

<style lang="scss" scoped>
.slide-list {
    display: flex;
    height: 100%;
    flex-direction: column;

    .slide-view {
        flex: 1;
        position: relative;

        .left-arrow,
        .right-arrow {
            width: 50px;
            height: 50px;
            background: rgb(99, 182, 99);
            padding: 10px;
            position: absolute;
            font-size: 1.5em;
            font-weight: bold;
            color: rgb(214, 240, 185);
            top: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: 0.3s;
            border: 2px solid transparent;
            user-select: none;

            &.disabled {
                opacity: 0.5;
                // background: rgb(189, 236, 189);
            }

            &:hover {
                background: white;
                cursor: pointer;
                color: green;
                border: 2px solid green;
            }
        }
        .left-arrow {
            left: 0;
            transform: translate(-45%, -50%);
        }
        .right-arrow {
            right: 0;
            transform: translate(45%, -50%);
        }
    }
}
</style>
