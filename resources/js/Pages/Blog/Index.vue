<template>
  <div>
    <Head>
        <title>Blog page</title>
        <meta name="description" content="blog page">
    </Head>
    <p>Blog test</p>
    <div v-for="blog in blogs" :key="blog">
      <p>Blog title: {{ blog.title }}</p>
      <p>Blog body: {{ blog.body }}</p>
      <br />
      <!-- <form @submit.prevent="store">
        <label for="title">title:</label>
        <input id="title" v-model="form.title" />
        <label for="Body">Body:</label>
        <input id="Body" v-model="form.Body" />
        <button type="store">Submit</button>
      </form> -->
    </div>
    <br />
    <Link href="/home" class="text-blue-400">Home</Link>
  </div>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
  props: {
    blogs: Object,
  },
  components: {
    Head,
    Link,
  },
};
</script>

<style>
</style>