<template>
    <div>
        <Nav :navItems="navItems" />

        <div class="p-4">
            <div v-if="!post">Loading...</div>

            <PostForm v-else :post="post" :errors="errors" action="Update" @submit="updatePost" />
        </div>
    </div>
</template>

<script>
import PostService from "../services/PostService";
import Nav from "./Nav";
import PostForm from "./PostForm";

export default {
    name: "CreateOrUpdatePost",
    components: { PostForm, Nav },
    data() {
        return {
            post: null,
            navItems: [
                {
                    text: "Post list",
                    active: false,
                    href: "/",
                },
                {
                    text: "Update post",
                    href: "#",
                    active: true,
                },
            ],
            errors: {
                post_title: "",
                post_text: "",
                cate_id: "",
            },
        };
    },
    mounted() {
        this.fetchPost();
    },
    methods: {
        async updatePost() {
            const response = await PostService.updatePost(
                this.post.id,
                this.post,
                (response) => {
                    this.$emit("onUpdatePost");
                    this.$router.push({ name: "posts" });
                },
                ({ message, errors }) => {
                    this.errors = errors;
                    console.log(this.errors);
                }
            );
        },

        async fetchPost() {
            this.post = await PostService.getPost(this.$route.params.id);
        },
    },
};
</script>
