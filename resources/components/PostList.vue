<template>
  <div>
    <table class="table">
      <thead>
        <tr>
          <th @click="onSort('post_title')">
            <span>Title</span>
            <font-awesome-icon
              v-if="sortField === 'post_title'"
              :icon="sortAscending ? 'arrow-up' : 'arrow-down'"
            />
          </th>

          <th @click="onSort('post_text')">
            <span>Post Text</span>
            <font-awesome-icon
              v-if="sortField === 'post_text'"
              :icon="sortAscending ? 'arrow-up' : 'arrow-down'"
            />
          </th>

          <th @click="onSort('post_created_at')">
            <span>Created Date</span>
            <font-awesome-icon
              v-if="sortField === 'post_created_at'"
              :icon="sortAscending ? 'arrow-up' : 'arrow-down'"
            />
          </th>

          <th><span>Action</span></th>
        </tr>
        <tr>
          <th>
            <input
              type="text"
              class="form-control"
              v-model="searchData.post_title"
              @input="onSearch"
            />
          </th>
          <th>
            <input
              type="text"
              class="form-control"
              @input="onSearch"
              v-model="searchData.post_text"
            />
          </th>
          <th>
            <input
              type="date"
              class="form-control"
              @input="onSearch"
              v-model="searchData.post_created_at"
            />
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="post in posts" :key="post.id">
          <td>{{ post.post_title }}</td>
          <td>{{ post.post_text }}</td>
          <td>{{ post.post_created_at }}</td>
          <td>
            <div class="d-flex justify-content-center m-3">
              <button
                type="button text-white"
                @click="editPost(post.id)"
                class="btn btn-sm btn-info"
              >
                Edit
              </button>
              <button
                style="margin-left: 10px"
                type="button"
                @click="deletePost(post.id)"
                class="btn btn-sm btn-danger"
              >
                Delete
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <!--Pagination-->
    <pagination
      v-if="paginationData.total_page > 1"
      :paginationData="paginationData"
      @onPrevPage="prevPage"
      @onNextPage="nextPage"
      @onGoToPage="goToPage"
    />
  </div>
</template>

<script>
import PostService from "../services/PostService";
import Pagination from "./Pagination.vue";
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faArrowUp, faArrowDown } from "@fortawesome/free-solid-svg-icons";

library.add(faArrowUp, faArrowDown);

export default {
  name: "PostList",
  components: { FontAwesomeIcon, Pagination },
  props: {
    posts: {
      type: Array,
      required: true,
    },
    searchData: {
      type: Object,
      required: false,
    },
    paginationData: {
      type: Object,
      required: false,
    },
  },
  data() {
    return {
      sortField: "",
      sortOrder: "asc",
      sortAscending: true,
    };
  },
  mounted() {},
  methods: {
    onSort(sortField) {
      if (this.sortField === sortField) {
        this.sortOrder = this.sortOrder === "asc" ? "desc" : "asc";
        this.sortAscending = !this.sortAscending;
      } else {
        this.sortField = sortField;
        this.sortOrder = "asc";
        this.sortAscending = true;
      }

      this.sortOrder = this.sortAscending ? "asc" : "desc";

      this.$emit("onSort", {
        sortField: this.sortField,
        sortOrder: this.sortOrder,
      });
    },

    editPost(postId) {
      this.$router.push({ name: "edit-post", params: { id: postId } });
    },

    async deletePost(postId) {
      const confirmed = window.confirm("Are you sure to delete this post?");

      if (!confirmed) {
        return;
      }

      const response = await PostService.deletePost(postId);

      this.$emit("onDeletePost");
    },

    prevPage() {
      this.$emit("onPrevPage");
    },

    nextPage() {
      this.$emit("onNextPage");
    },

    goToPage(page) {
      this.$emit("onGoToPage", page);
    },

    onSearch() {
      this.$emit("onSearch", this.searchData);
    },
  },
};
</script>

<style scoped>
button {
  color: #fff !important;
}

th span{
    color: #0038ff;
}
</style>
