<template>
    <div class="d-flex justify-content-center">
        <Form @submit="handleSubmit" title="Signup with Eduslide">
            <Input label="Name" type="text" v-model="name" />
            <Input label="Email" type="text" v-model="email" />
            <Input label="Password" type="password" v-model="password" />
            <Button title="Signup" />
        </Form>
    </div>
</template>

<script>
import Form from "../components/Form.vue";
import Input from "../components/Input.vue";
import Button from "../components/Button.vue";
import { mapActions } from "vuex";

export default {
    components: { Form, Input, Button },
    data() {
        return {
            name: "",
            email: "",
            password: ""
        };
    },
    methods: {
        ...mapActions("auth", ["getUser"]),
        async handleSubmit() {
            const name = this.name;
            const email = this.email;
            const password = this.password;

            if (!email || !password || !name) {
                Vue.$toast.error("Please enter name, email and password");
            }
            try {
                const res = await axios.post("/auth/register", {
                    name,
                    email,
                    password
                });
                await this.getUser(res.data.access_token);
                Vue.$toast.success("Registered Successfully");
                this.$router.replace({ name: "home" });
            } catch (err) {
                console.log("some error in registering user", err);
                Vue.$toast.error("Some error occured");
            }
        }
    }
};
</script>

<style></style>
