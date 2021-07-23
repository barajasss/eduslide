<template>
    <button class="custom-btn" @click="$emit('click')">{{ title }}</button>
</template>

<script>
export default {
    props: {
        title: { type: String, default: "OK" }
    },
    emits: ["click"]
};
</script>

<style lang="scss" scoped>
.custom-btn {
    padding: 10px;
    border: none;
    background: rgb(76, 76, 240);
    color: white;
    min-width: 150px;

    &:hover {
        background: rgb(41, 41, 238);
    }
}
</style>
