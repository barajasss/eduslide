import axios from "axios";

const accessToken = () => localStorage.getItem("access_token");
const authConfig = token => ({
    headers: {
        Authorization: `Bearer ${token}`
    }
});
const authStore = {
    namespaced: true,
    state: {
        user: null,
        authenticated: false
    },
    mutations: {
        SET_USER(state, payload) {
            state.user = payload;
            state.authenticated = true;
        },
        UNSET_USER(state) {
            state.user = null;
            state.authenticated = false;
        }
    },
    actions: {
        async getUser(context, token) {
            if (token) {
                localStorage.setItem("access_token", token);
            } else {
                token = accessToken();
            }
            try {
                const res = await axios.get("/auth/me", authConfig(token));

                if (res.data.id) {
                    context.commit("SET_USER", res.data);
                } else {
                    context.commit("UNSET_USER");
                }
            } catch (err) {
                console.log("error", err);
                context.commit("UNSET_USER");
            }
        },
        async logout(context) {
            try {
                await axios.post("/auth/logout", {}, authConfig(accessToken()));
                context.commit("UNSET_USER");
            } catch (err) {
                console.log("some erorr in logging out");
            }
        }
    }
};

export default authStore;
