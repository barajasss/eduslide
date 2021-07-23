<template>
    <div class="header">
        <div class="header-title">Eduslide</div>
        <div class="header-links" v-if="authenticated">
            <router-link :to="{ name: 'home' }">Home</router-link>
            <router-link :to="{ name: 'profile' }">Profile</router-link>
            <a href="javascript:void(0)" @click="logoutUser">Logout</a>
        </div>
        <div class="header-links" v-else>
            <router-link :to="{ name: 'home' }">Home</router-link>
            <router-link :to="{ name: 'login' }">Login</router-link>
            <router-link :to="{ name: 'register' }">Register</router-link>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from "vuex";

export default {
    computed: {
        ...mapState("auth", ["authenticated"])
    },
    methods: {
        ...mapActions("auth", ["logout"]),
        logoutUser() {
            this.logout();
            this.$router.replace({ name: "home" });
        }
    }
};
</script>

<style lang="scss" scoped>
.header {
    background: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;

    .header-title {
        color: blue;
        font-size: 1.5em;
    }
    .header-links {
        align-items: center;
        display: flex;
        justify-content: space-between;

        & > * {
            margin: 5px 20px;
        }
    }
}
</style>
