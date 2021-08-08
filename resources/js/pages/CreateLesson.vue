<template>
    <div class="d-flex justify-content-center">
        <Form
            @submit="handleSubmit"
            :title="editMode ? 'Edit Lesson' : 'Create new Lesson'"
        >
            <Input label="Lesson Tilte" type="text" v-model="lessonTitle" />
            <Input
                label="Lesson Description"
                type="textarea"
                v-model="lessonDescription"
            />
            <div v-if="enabledSlides.length" class="slides-main-title">
                SLIDES TO SHOW
            </div>
            <template v-for="(slide, i) in slides">
                <div class="slide-form" v-if="!slide.disabled" :key="i">
                    <div>
                        <div class="slide-form-title">
                            Slide {{ getSlideNumber(i) }}
                        </div>
                        <button
                            type="button"
                            class="close"
                            @click="removeSlide(slide.uuid || slide.id)"
                        >
                            &times;
                        </button>
                        <Input
                            label="Slide Tilte"
                            type="text"
                            v-model="slide.title"
                        />
                        <Input
                            label="Slide Content"
                            type="editor"
                            :index="slide.uuid || slide.id"
                            v-model="slide.content"
                            :useDefaultHtml="!slide.noDefaultHtml"
                        />
                    </div>
                </div>
            </template>
            <Button
                title="Add Slide"
                icon="fas fa-plus"
                @click="addSlide"
                type="button"
            />
            <Button
                :title="editMode ? 'Save Lesson' : 'Create Lesson'"
                style="margin-left: 10px;"
            />
        </Form>
    </div>
</template>

<script>
import Form from "../components/Form.vue";
import Input from "../components/Input.vue";
import Button from "../components/Button.vue";
import { v4 as uuid } from "uuid";
import { mapState, mapActions } from "vuex";

export default {
    components: { Form, Input, Button },
    data() {
        return {
            lessonTitle: "",
            lessonDescription: "",
            slides: [],
            slideNumbers: [],
            editMode: false,
            lessonId: 0
        };
    },
    computed: {
        ...mapState("auth", ["user"]),
        enabledSlides() {
            return this.slides.filter(slide => !slide.disabled);
        }
    },
    watch: {
        slides(e) {
            let id = 0;
            this.slideNumbers = e.map((slide, i) => {
                if (!slide.disabled) {
                    id++;
                    return id;
                }
            });
        }
    },
    mounted() {
        const lessonId = this.$route.params.id;
        if (lessonId) {
            this.editMode = true;
            this.lessonId = lessonId;
            this.fetchLesson();
        }
    },
    methods: {
        async fetchLesson() {
            const res = await axios.get("/lessons/" + this.$route.params.id);
            const lesson = res.data;
            this.lessonTitle = lesson.title;
            this.lessonDescription = lesson.description;

            if (lesson) {
                const res = await axios.get(
                    "/slides?lesson_id=" + this.lessonId
                );
                this.slides = res.data;
            }
        },
        async handleSubmit() {
            if (this.enabledSlides.length > 0) {
                // create authenticated requests

                if (
                    !this.lessonTitle ||
                    !this.lessonDescription ||
                    this.enabledSlides.find(
                        slide => !slide.title || !slide.content
                    )
                ) {
                    return Vue.$toast.error("Please fill up all the fields");
                }

                const config = {
                    headers: {
                        Authorization: `Bearer ${window.localStorage.getItem(
                            "access_token"
                        )}`
                    }
                };

                // first create/update the lesson...

                let url = "/lessons";
                let method = "post";

                if (this.editMode) {
                    method = "patch";
                    url = "/lessons/" + this.lessonId;
                }

                const res = await axios[method](
                    url,
                    {
                        user_id: this.user.id,
                        title: this.lessonTitle,
                        description: this.lessonDescription
                    },
                    config
                );

                let lessonId = res.data.id;

                if (this.editMode) {
                    lessonId = this.lessonId;
                }

                // add slides one by one...
                for await (let slide of this.enabledSlides) {
                    if (this.editMode && slide.id) {
                        method = "patch";
                        url = "/slides/" + slide.id;
                    } else {
                        method = "post";
                        url = "/slides";
                    }
                    await axios[method](
                        url,
                        {
                            lesson_id: lessonId,
                            title: slide.title,
                            content: slide.content
                        },
                        config
                    );
                }
                Vue.$toast.success("Lesson created successfully!");
                this.$router.push({ name: "home" });
            } else {
                Vue.$toast.error("Please add at least 1 slide");
            }
        },
        addSlide() {
            this.slides.push({
                // id: this.randomNumbers(),
                uuid: uuid(),
                title: "",
                content: "",
                noDefaultHtml: true
            });
        },
        removeSlide(id) {
            console.log("id of slide to remove", id, this.slides);
            this.slides = this.slides.map(slide => {
                if (slide.id === id || slide.uuid === id) {
                    slide.disabled = true;
                }
                return slide;
            });
        },
        getSlideNumber(i) {
            return this.slideNumbers[i];
        },
        randomNumbers(length = 10) {
            let rand = "";
            for (let i = 0; i < length; i++) {
                rand += Math.random() >= 0.5 ? "1" : "0";
            }
            return Number(rand);
        }
    }
};
</script>

<style lang="scss" scoped>
.slides-main-title {
    margin-top: 35px;
    margin-bottom: 15px;
    text-align: center;
    font-size: 1.2em;
    background: rgb(91, 144, 243);
    color: white;
    padding: 10px;
    border-bottom: 1px solid #ccc;
}
.slide-form {
    margin: 15px 0;
    margin-bottom: 25px;
    background: #d8e5fe;
    padding: 15px 10px;
    position: relative;

    .slide-form-title {
        font-size: 1.2em;
        text-align: center;
    }
    .close {
        position: absolute;
        right: 20px;
        top: 20px;
    }
}
</style>
