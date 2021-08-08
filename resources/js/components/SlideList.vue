<template>
    <div :class="['slide-list', { fullScreenMode }]" ref="slideList">
        <div class="slide-view">
            <Slide
                :title="currentSlide.title"
                :content="currentSlide.content"
                :number="index + 1"
                :totalSlides="slides.length"
                :showIndex="slides.length > 1"
            />
            <button
                class="close"
                v-if="fullScreenMode"
                @click="exitFullScreen()"
            >
                &times;
            </button>
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
            },
            fullScreenMode: false
        };
    },
    async mounted() {
        await this.getSlides(this.lessonId);
        this.index = 0;
        this.currentSlide = this.slides[this.index];
        document.addEventListener("keydown", this.handleKeyDown);
        document.addEventListener("fullscreenchange", this.handleFullScreen);
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
        },
        handleKeyDown(e) {
            switch (e.key) {
                case "ArrowLeft": {
                    this.updateIndex(this.index - 1);
                    break;
                }
                case "ArrowRight": {
                    this.updateIndex(this.index + 1);
                    break;
                }
                case "f": {
                    if (document.fullscreenElement) {
                        this.exitFullScreen();
                    } else {
                        this.enableFullScreen();
                    }
                    break;
                }
            }
        },
        enableFullScreen() {
            const el = this.$refs.slideList;
            if (el.requestFullscreen) {
                el.requestFullscreen();
            }
        },
        exitFullScreen() {
            document.exitFullscreen();
        },
        handleFullScreen() {
            if (document.fullscreenElement) {
                this.fullScreenMode = true;
            } else {
                this.fullScreenMode = false;
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

        .close {
            position: absolute;
            right: 25px;
            top: 15px;
            font-size: 2em;
        }
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

.slide-list.fullScreenMode {
    .slide-view {
        flex: 1;
        position: relative;

        .left-arrow {
            left: 0;
            transform: translate(5%, -50%);
        }
        .right-arrow {
            right: 0;
            transform: translate(-5%, -50%);
        }
    }
}
</style>
