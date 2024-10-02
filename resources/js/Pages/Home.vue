<script setup>
// import Nav from "../Shared/Nav.vue";
// import Layout from "../Shared/Layout.vue";

// defineOptions({ layout: Layout });

defineProps({
    name: String,
    frameworks: Array,
});
/* export default {
  props: {
    name: String,
    frameworks: Array,
  },
  components: { Nav },
}; */
</script>

<template>
    <Head>
        <title>Home</title>
        <meta
            type="description"
            content="Home information"
            head-key="description"
        />
    </Head>
    
    <h1 class="text-4xl font-bold">Hello {{ name }}</h1>
    <p>In this series, we will use the following frameworks:</p>
    <ul>
        <li v-for="framework of frameworks" v-text="framework"></li>
    </ul>
</template>
