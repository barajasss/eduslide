<template>
    <div class="d-flex justify-content-center">
        <Form @submit="handleSubmit" title="Create new Lesson">
            <Input label="Lesson Tilte" type="text" v-model="lessonTitle" />
            <Input
                label="Lesson Description"
                type="textarea"
                v-model="lessonDescription"
            />
            <div v-if="slides.length" class="slides-main-title">
                SLIDES TO SHOW
            </div>
            <div class="slide-form" v-for="(slide, i) in slides" :key="i">
                <div class="slide-form-title">Slide {{ i + 1 }}</div>
                <Input label="Slide Tilte" type="text" v-model="slide.title" />
                <Input
                    label="Slide Content"
                    type="editor"
                    :index="i"
                    v-model="slide.content"
                />
            </div>
            <Button
                title="Add Slide"
                icon="fas fa-plus"
                @click="addSlide"
                type="button"
            />
            <Button title="Create Lesson" style="margin-left: 10px;" />
        </Form>
    </div>
</template>

<script>
import Form from "../components/Form.vue";
import Input from "../components/Input.vue";
import Button from "../components/Button.vue";
import { mapState, mapActions } from "vuex";

export default {
    components: { Form, Input, Button },
    data() {
        return {
            lessonTitle: "",
            lessonDescription: "",
            slides: []
        };
    },
    computed: {
        ...mapState("auth", ["user"])
    },
    methods: {
        async handleSubmit() {
            if (this.slides.length > 0) {
                // create authenticated requests

                if (
                    !this.lessonTitle ||
                    !this.lessonDescription ||
                    this.slides.find(slide => !slide.title || !slide.content)
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

                // first create the lesson...
                const res = await axios.post(
                    "/lessons",
                    {
                        user_id: this.user.id,
                        title: this.lessonTitle,
                        description: this.lessonDescription
                    },
                    config
                );

                let lessonId = res.data.id;

                // add slides one by one...
                for await (let slide of this.slides) {
                    await axios.post(
                        "/slides",
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
        addSlide(id) {
            this.slides.push({ title: "", content: "" });
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

    .slide-form-title {
        font-size: 1.2em;
        text-align: center;
    }
}
</style>
