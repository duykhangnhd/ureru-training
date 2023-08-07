<template>
  <div>
    <Nav :navItems="navItems" />

    <div class="p-4">
      <PostCate
        :categories="categories"
        @onSelectCate="onSelectCate"
      ></PostCate>

      <div v-if="isFetching">Loading...</div>
      <PostList
        v-else
        :posts="posts"
        :searchData="searchData"
        :paginationData="paginationData"
        @onPrevPage="onPrevPage"
        @onNextPage="onNextPage"
        @onGoToPage="onGoToPage"
        @onSort="onSort"
        @onSearch="onSearch"
        @onDeletePost="onDeletePost"
      ></PostList>
    </div>
  </div>
</template>

<script>
import PostList from "./PostList";
import PostCate from "./PostCate";
import PostService from "../services/PostService";
import CateService from "../services/CateService";
import "../utils/prototype";
import Nav from "./Nav";
export default {
  name: "App",
  components: { PostList, PostCate, Nav },
  data() {
    return {
      isFetching: true,
      navItems: [
        {
          text: "Post list",
          active: true,
          href: "#",
        },
        {
          text: "Add new post",
          href: "/create-post",
          active: false,
        },
      ],
      categories: [],
      cateSelected: null,
      posts: [],
      searchData: {
        post_title: "",
        post_text: "",
        post_created_at: "",
      },
      sortData: {
        sort_field: "",
        sort_order: "",
      },
      paginationData: {
        current_page: 1,
        total_page: 1,
      },
    };
  },
  mounted() {
    this.fetchCates();
    this.fetchPosts();
  },

  computed: {
    isSearchDataEmpty() {
      return (
        this.searchData.post_title === "" &&
        this.searchData.post_text === "" &&
        this.searchData.post_created_at === ""
      );
    },
  },
  methods: {
    onSelectCate(categoryId) {
      this.cateSelected = categoryId;
      this.searchData.cate_id = categoryId;

      this.paginationData = {
        current_page: 1,
        total_page: 1,
      };

      if (this.isSearchDataEmpty) {
        return this.fetchPosts();
      }
      return this.searchPosts();
    },

    onDeletePost() {
      this.fetchPosts();
    },

    onSearch(searchData) {
      this.searchData = {
        ...searchData,
        cate_id: this.cateSelected,
      };

      this.paginationData = {
        current_page: 1,
        total_page: 1,
      };

      this.searchPosts();
    },

    async searchPosts() {
      const response = await PostService.searchPosts(this.searchData, {
        page: this.paginationData.current_page,
      });

      this.posts = response.data;
      this.paginationData.total_page = response.total_page;
    },

    onSort({ sortField, sortOrder }) {
      this.posts.sortByField(sortField, sortOrder);
    },

    onPrevPage() {
      if (this.paginationData.current_page > 1) {
        this.paginationData.current_page--;

        if (this.isSearchDataEmpty) {
          return this.fetchPosts();
        }
        return this.searchPosts();
      }
    },

    onNextPage() {
      if (this.paginationData.current_page < this.paginationData.total_page) {
        this.paginationData.current_page++;

        if (this.isSearchDataEmpty) {
          return this.fetchPosts();
        }
        return this.searchPosts();
      }
    },

    onGoToPage(page) {
      this.paginationData.current_page = page;

      if (this.isSearchDataEmpty) {
        return this.fetchPosts();
      }
      return this.searchPosts();
    },

    async fetchCates() {
      this.categories = await CateService.getCates();
    },

    async fetchPosts() {
      const response = await PostService.getPosts({
        cate_id: this.cateSelected,
        page: this.paginationData.current_page,
      });

      // Check if is pagination from search or fetch normal posts
      this.posts = response.data;
      this.paginationData.total_page = response.total_page;

      this.isFetching = false;

      console.log("fetch posts");
    },
  },
};
</script>
