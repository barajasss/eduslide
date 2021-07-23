<template>
    <div>
        <h1>Myprofile</h1>
        <div>Name: {{ user.name }}</div>
        <div>email: {{ user.email }}</div>
    </div>
</template>

<script>
import { mapState, mapActions } from "vuex";
export default {
    computed: {
        ...mapState("auth", ["user"])
    }
};
</script>

<style></style>
