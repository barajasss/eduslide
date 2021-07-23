<template>
    <div class="lesson-card">
        <div class="lesson-title">Lesson element</div>
        <div class="lesson-description">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit.
            Dignissimos excepturi, asperiores similique quam temporibus nam
            culpa mollitia voluptas quasi blanditiis delectus ad minima
            praesentium. Perferendis sequi aspernatur saepe est optio.
        </div>
        <Button title="Take Lesson" />
    </div>
</template>

<script>
import Button from "./Button";
export default {
    components: { Button }
};
</script>

<style lang="scss" scoped>
.lesson-card {
    background: white;
    padding: 50px;
    margin-bottom: 20px;

    .lesson-title {
        font-size: 2em;
    }

    .lesson-description {
        margin: 10px 0;
        margin-bottom: 20px;
    }
}
</style>
