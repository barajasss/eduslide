import Home from "../pages/Home";
import Login from "../pages/Login";
import Register from "../pages/Register";
import Profile from "../pages/Profile";
import Lesson from "../pages/Lesson";
import CreateLesson from "../pages/CreateLesson";
import Favorites from "../pages/Favorites";
import MyLessons from "../pages/MyLessons";

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
    },
    {
        path: "/lessons/:id",
        name: "lesson",
        component: Lesson
    },
    {
        path: "/create",
        name: "create_lesson",
        component: CreateLesson
    },
    {
        path: "/edit/:id",
        name: "edit_lesson",
        component: CreateLesson
    },
    {
        path: "/favorites",
        name: "favorites",
        component: Favorites
    },
    {
        path: "/my-lessons",
        name: "my_lessons",
        component: MyLessons
    }
];

export default routes;
