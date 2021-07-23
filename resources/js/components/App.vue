<template>
    <div class="app-container">
        <Header />
        <div style="flex: 1;" class="container p-4">
            <router-view></router-view>
        </div>
        <Footer />
    </div>
</template>

<script>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
import { mapActions } from "vuex";

export default {
    async mounted() {
        await this.getUser();
    },
    methods: {
        ...mapActions("auth", ["getUser"])
    },
    components: { Header, Footer }
};
</script>

<style lang="scss" scoped>
.app-container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
</style>
