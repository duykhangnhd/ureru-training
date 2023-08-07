<template>
    <ul class="nav">
        <li
            v-for="item in navItems"
            :key="item.text"
            :class="{ active: item.active }"
        >
            <router-link :to="item.href" class="nav-link">
                {{ item.text }}
            </router-link>
        </li>
    </ul>
</template>

<script>
export default {
    name: "Nav",
    props: {
        navItems: Array,
    },
};
</script>

<style scoped>
.nav {
    background-color: #ffffff;
}
.nav {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}
.nav .active a {
    color: black;
    text-decoration: underline;
}

.nav a {
    color: #6c757d;
}
</style>
