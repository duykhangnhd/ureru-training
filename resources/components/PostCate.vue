<template>
    <div class="post-cate mt-2 mb-3">

        <select v-model="selectedCategory" @change="onCategorySelected" class="form-control">
            <option :value="null" :selected="selectedCategory === null">-- Choose category --</option>
            <option
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
            >
                {{ category.cate_name }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    name: "PostCate",
    props: {
        categories: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            selectedCategory: null,
        };
    },
    methods: {
        onCategorySelected() {
            this.$emit("onSelectCate", this.selectedCategory);
        },
    },
};
</script>

<style>
.post-cate {
    width: 30%;
}
</style>
