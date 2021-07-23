<template>
    <div class="form-container">
        <div class="form-heading">
            {{ title }}
        </div>
        <form @submit.prevent="$emit('submit')">
            <slot></slot>
        </form>
    </div>
</template>

<script>
import Input from "./Input.vue";
export default {
    props: {
        title: {
            type: String
        }
    },
    emits: ["submit"],
    components: { Input }
};
</script>

<style lang="scss" scoped>
.form-container {
    background: white;
    max-width: 600px;
    width: 90%;
    padding: 25px;

    .form-heading {
        font-size: 1.5em;
        margin-bottom: 10px;
        text-align: center;
    }
}
</style>
