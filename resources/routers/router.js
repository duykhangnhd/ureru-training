import Vue from "vue";
import VueRouter from "vue-router";
import Post from "../components/Post";
import UpdatePost from "../components/UpdatePost";
import CreatePost from "../components/CreatePost";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: "/",
            name: "posts",
            component: Post,
        },
        {
            path: "/create-post",
            name: "create-post",
            component: CreatePost,
        },
        {
            path: "/posts/edit/:id",
            name: "edit-post",
            component: UpdatePost,
        },
    ],
});
