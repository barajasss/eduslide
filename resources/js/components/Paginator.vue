<template>
    <div class="paginator" v-if="totalPages">
        <Button
            title="Prev"
            style="width: 100px; margin-right: 10px"
            @click="updatePage(page - 1)"
        />
        <template v-for="i in totalPages">
            <Button
                :title="i"
                :key="i"
                style="min-width: 60px; margin-right: 10px"
                :inverted="i !== page"
                @click="updatePage(i)"
            />
        </template>
        <Button
            title="Next"
            style="width: 100px;"
            @click="updatePage(page + 1)"
        />
    </div>
</template>

<script>
import Button from "./Button";
export default {
    components: { Button },
    emits: ["update"],
    props: {
        page: {
            type: Number,
            default: 1
        },
        itemsPerPage: {
            type: Number,
            default: 10
        },
        totalResults: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {};
    },
    watch: {
        page(e) {
            this.$router.push({
                name: this.$route.name,
                query: {
                    page: e
                }
            });
        }
    },
    methods: {
        updatePage(i) {
            if (i > 0 && i <= this.totalPages) {
                this.$emit("update", {
                    page: i
                });
            }
        }
    },
    computed: {
        totalPages() {
            return Math.ceil(this.totalResults / this.itemsPerPage);
        }
    }
};
</script>

<style lang="scss" scoped>
.paginator {
    margin: 30px 0;
    margin-top: 50px;
    display: flex;
    justify-content: center;
}
</style>
