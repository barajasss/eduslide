<template>
    <div class="home-options">
        <template v-if="authenticated">
            <Button
                title="My Lessons"
                icon="fas fa-list"
                style="margin-right: 10px;"
                @click="$router.push({ name: 'my_lessons' })"
                inverted
            />
            <Button
                title="View Favorites"
                style="margin-right: 10px;"
                icon="fas fa-heart"
                @click="$router.push({ name: 'favorites' })"
                inverted
            />
            <Button
                title="Create a Lesson"
                icon="fas fa-plus"
                @click="$router.push({ name: 'create_lesson' })"
                inverted
            />
        </template>
        <template v-else>
            <Button
                title="Login to Create Slides"
                @click="$router.push({ name: 'login' })"
            />
        </template>
    </div>
</template>

<script>
import Button from "./Button";
import { mapState, mapActions } from "vuex";

export default {
    components: { Button },
    computed: {
        ...mapState("auth", ["authenticated"])
    }
};
</script>

<style lang="scss" scoped>
.home-options {
    margin-bottom: 20px;
}
</style>
