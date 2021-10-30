<template>
  <div>
      <Head>Testing Inertia</Head>
      <Link href="/blog">Blog</Link>
  </div>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
export default {
  props: ['title'],
  components: {
    Head,
    Link,
  },
};
</script>

<style>

</style>