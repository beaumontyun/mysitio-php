<template>
  <div>
    <Head>
      <title>Testing Inertia</title>
      <meta name="description" content="home page">
    </Head>
    <h1>Testing home page</h1>
    <br>
    <Link href="/blog" class="text-blue-400">Blog</Link>
  </div>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";

export default {
  props: ["title"],
  components: {
    Head,
    Link,
  },
};
</script>

<style>
</style>