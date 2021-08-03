<template>
    <div class="slide-item">
        <div class="slide-index" v-if="number && showIndex">
            {{ number }} of {{ totalSlides }}
        </div>
        <div class="slide-title">{{ title }}</div>
        <div class="slide-content" v-html="content" />
    </div>
</template>

<script>
export default {
    props: {
        title: { type: String, default: "" },
        content: { type: String, default: "" },
        number: { type: Number },
        totalSlides: { type: Number },
        showIndex: { type: Boolean }
    }
};
</script>

<style lang="scss" scoped>
.slide-item {
    width: 100%;
    height: 100%;
    padding: 20px 40px;
    background: #ccc;
    position: relative;

    .slide-title {
        font-size: 1.5em;
        text-align: center;
        padding-bottom: 10px;
        margin-bottom: 20px;
        border-bottom: 1px solid #aaa;
    }
    .slide-index {
        position: absolute;
        top: 0;
        left: 0;
        background: rgb(69, 156, 255);
        color: white;
        font-size: 1em;
        width: 100px;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .slide-content {
    }
}
</style>
