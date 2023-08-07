<template>
  <!---->
  <nav
    aria-label="Page navigation example"
    v-if="paginationData.total_page > 1"
  >
    <ul class="pagination justify-content-start ml-auto">
      <li
        :class="{
          'page-item': true,
          disabled: paginationData.current_page === 1,
        }"
      >
        <a class="page-link" href="#" @click.prevent="prevPage">
          <i class="fa-solid fa-angles-left"></i>
        </a>
      </li>

      <li
        v-for="page in paginationData.total_page"
        :key="page"
        :class="{
          'page-item': true,
          active: page === paginationData.current_page,
        }"
      >
        <a class="page-link" href="#" @click.prevent="goToPage(page)">{{
          page
        }}</a>
      </li>

      <li
        :class="{
          'page-item': true,
          disabled: paginationData.current_page === paginationData.total_page,
        }"
      >
        <a class="page-link" @click.prevent="nextPage" href="#">
          <i class="fa-solid fa-angles-right"></i>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: "Pagination",
  props: {
    paginationData: {
      type: Object,
      required: true,
    },
  },
  methods: {
    prevPage() {
      this.$emit("onPrevPage");
    },

    nextPage() {
      this.$emit("onNextPage");
    },

    goToPage(page) {
      this.$emit("onGoToPage", page);
    },
  },
};
</script>


<style scoped>
    svg{
        font-size: 10px;
    }
</style>
