import Home from "../pages/Home";
import Login from "../pages/Login";
import Register from "../pages/Register";
import Profile from "../pages/Profile";

const routes = [
    {
        path: "/",
        name: "home",
        component: Home
    },
    {
        path: "/login",
        name: "login",
        component: Login
    },
    {
        path: "/register",
        name: "register",
        component: Register
    },
    {
        path: "/profile",
        name: "profile",
        component: Profile
    }
];

export default routes;
