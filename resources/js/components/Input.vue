<template>
    <div class="input-container">
        <label>
            {{ label }}
            <input
                class="input-element"
                :type="type"
                @input="$emit('valueChange', $event.target.value)"
                :value="value"
            />
        </label>
    </div>
</template>

<script>
export default {
    model: {
        prop: "value",
        event: "valueChange"
    },
    props: {
        value: { type: String },
        label: { type: String },
        type: { type: String, default: "text" }
    }
};
</script>

<style lang="scss" scoped>
.input-container {
    padding: 10px 0;

    label {
        display: block;
    }
    .input-element {
        padding: 10px;
        display: block;
        margin-top: 10px;
        width: 100%;
    }
}
</style>
