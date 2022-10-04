<template>
  <navbar></navbar>

  <router-view/>
</template>

<script>
import navbar from "./navbar.vue";

export default {
  data() {
    return {};
  },
  name: "app",
  components: {
    navbar,
  },
};
</script>