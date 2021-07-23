<template>
    <div class="d-flex justify-content-center">
        <Form @submit="handleSubmit" title="Login To Eduslide">
            <Input label="Email" type="text" v-model="email" />
            <Input label="Password" type="password" v-model="password" />
            <Button title="Login" />
        </Form>
    </div>
</template>

<script>
import Form from "../components/Form.vue";
import Input from "../components/Input.vue";
import Button from "../components/Button.vue";
import { mapState, mapActions, mapGetters } from "vuex";
import axios from "axios";

export default {
    components: { Form, Input, Button },
    data() {
        return {
            email: "",
            password: ""
        };
    },
    mounted() {
        console.log("the user is: ", this.user);
    },
    computed: {
        // ...mapState({
        //     user: state => state.auth.user
        // })
        ...mapState("auth", ["user"])
    },
    methods: {
        ...mapActions("auth", ["getUser"]),
        async handleSubmit() {
            const email = this.email;
            const password = this.password;

            if (!email || !password) {
                Vue.$toast.error("Please enter email and password");
            }
            try {
                const res = await axios.post("/auth/login", {
                    email,
                    password
                });
                if (res.data.access_token) {
                    await this.getUser(res.data.access_token);
                    Vue.$toast.success("Registered Successfully");
                    this.$router.replace({ name: "home" });
                } else {
                    Vue.$toast.error("Some error occured");
                }
            } catch (err) {
                console.log("some error in registering user", err);
                Vue.$toast.error("Some error occured");
            }
        }
    }
};
</script>

<style></style>
