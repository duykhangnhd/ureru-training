<template>
  <div>
    <Nav :navItems="navItems" />
    <div class="p-4">
      <PostForm
        :post="post"
        :errors="errors"
        action="Create"
        @submit="createPost"
      />
    </div>
  </div>
</template>

<script>
import PostForm from "./PostForm";
import Nav from "./Nav";
import PostService from "../services/PostService";

export default {
  name: "CreatePost",
  components: { PostForm, Nav },
  data() {
    return {
      navItems: [
        {
          text: "Post list",
          active: false,
          href: "/",
        },
        {
          text: "Add post",
          href: "#",
          active: true,
        },
      ],
      post: {
        post_title: "",
        post_text: "",
        cate_id: null,
      },
      errors: {
        post_title: '',
        post_text: '',
        cate_id: '',
      },
    };
  },
  methods: {
    async createPost(post) {
      const response = await PostService.createPost(
        this.post,
        (response) => {
          this.$emit("onCreatePost");
          this.$router.push({ name: "posts" });
        },
        ({ message, errors }) => {
          this.errors = errors;
          console.log(this.errors);
        }
      );
    },
  },
};
</script>
