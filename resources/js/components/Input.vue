<template>
    <div :class="['input-container']">
        <template v-if="type === 'editor'">
            <div class="editor-title">{{ label }}</div>
            <div
                :id="`editor-${index}`"
                class="editor"
                v-if="useDefaultHtml"
                v-html="value"
            ></div>
            <div :id="`editor-${index}`" class="editor"></div>
        </template>
        <label v-else>
            {{ label }}
            <textarea
                class="textarea-input"
                v-if="type === 'textarea'"
                rows="5"
                :value="value"
                @input="$emit('valueChange', $event.target.value)"
            >
            </textarea>
            <input
                v-else
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
        type: { type: String, default: "text" },
        index: { type: [Number, String] },
        useDefaultHtml: { type: Boolean, default: false }
    },
    mounted() {
        if (this.type === "editor") {
            const id = "#editor-" + this.index;
            const quill = new Quill(id, {
                theme: "snow"
            });
            quill.on("editor-change", () => {
                const innerId = id + " .ql-editor";
                const contents = document.querySelector(innerId).innerHTML;
                this.$emit("valueChange", contents);
            });
        }
    }
};
</script>

<style>
.ql-toolbar.ql-snow {
    background: white;
}
.ql-editor {
    height: 150px;
}
</style>
<style lang="scss" scoped>
.input-container {
    padding: 10px 0;

    &.is-editor {
        background: white;
    }

    label {
        display: block;
    }
    .input-element {
        padding: 10px;
        display: block;
        margin-top: 10px;
        width: 100%;
    }
    .textarea-input {
        display: block;
        resize: none;
        width: 100%;
        margin: 10px 0;
    }
    .editor {
        background: white;
    }
    .editor-title {
        margin-bottom: 10px;
    }
}
</style>
