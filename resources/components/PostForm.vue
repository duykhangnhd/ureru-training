<template>
  <div class="mt-3">
    <form @submit.prevent="submit">
      <div class="form-group">
        <input
          type="text"
          name="post_title"
          class="form-control"
          placeholder="Post title"
          v-model="post.post_title"
        />
        <small v-if="errors.post_title" class="text-danger">
            <p class="m-2">{{ errors.post_title }}</p>
        </small>
      </div>

      <div class="form-group mt-3">
        <textarea
          name="post_text"
          class="form-control"
          v-model="post.post_text"
          placeholder="Post text"
          rows="3"
        ></textarea>
        <small v-if="errors.post_text" class="text-danger">
            <p class="m-2">{{ errors.post_text }}</p>
        </small>
      </div>

      <div class="form-group mt-3">
        <select v-model="post.cate_id" class="form-control">
          <option :value="null" :selected="post.cate_id === null">
            -- Choose category --
          </option>
          <option
            v-for="category in categories"
            :key="category.id"
            :value="category.id"
          >
            {{ category.cate_name }}
          </option>
        </select>
        <small v-if="errors.cate_id" class="text-danger">
            <p class="m-2">{{ errors.cate_id }}</p>
        </small>
      </div>

      <b-button class="mt-2" type="submit" variant="info">{{
        action
      }}</b-button>
    </form>
  </div>
</template>

<script>
import CateService from "../services/CateService";
export default {
  name: "PostForm",
  props: {
    post: Object,
    action: String,
    errors: Object,
  },
  data() {
    return {
      categories: [],
    };
  },
  async mounted() {
    this.categories = await CateService.getCates();
  },

  methods: {
    submit() {
      // Validate before submit
      this.$emit("submit", this.post);
    },
  },
};
</script>
