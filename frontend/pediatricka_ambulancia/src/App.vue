<script>
import { provide, ref } from "vue";
import TopBar from "@/components/TopBar.vue";
import Navbar from "@/components/Navbar.vue";
import Footer from "@/components/Footer.vue";
import LoadingOverlay from "@/components/LoadingOverlay.vue";

export default {
  name: "App",
  components: {
    TopBar,
    Navbar,
    Footer,
    LoadingOverlay,
  },
  data() {
    return {
      isLoading: false,
    };
  },
  provide() {
    return {
      setLoading: this.setLoading,
    };
  },
  methods: {
    setLoading(value) {
      this.isLoading = value;
    },
  },
};
</script>

<template>
  <LoadingOverlay :isLoading="isLoading" />
  <TopBar />
  <Navbar />
  <RouterView />
  <Footer />
</template>

<style scoped>
</style>
