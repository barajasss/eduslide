<template>
    <button :class="['custom-btn', { inverted }]" @click="$emit('click')">
        {{ title }}
        <i :class="icon" v-if="icon" style="margin: 0 10px;" />
    </button>
</template>

<script>
export default {
    props: {
        title: { type: String, default: "" },
        inverted: { type: Boolean, default: false },
        icon: { type: String, default: "" }
    },
    emits: ["click"]
};
</script>

<style lang="scss" scoped>
$color: rgb(76, 76, 240);

.custom-btn {
    padding: 10px;
    border: none;
    background: $color;
    color: white;
    min-width: 150px;
    border: 2px solid lighten($color, 15%);

    &:hover {
        color: $color;
        background: white;
    }

    &.inverted {
        background: white;
        color: $color;

        &:hover {
            background: $color;
            color: white;
        }
    }
}
</style>
