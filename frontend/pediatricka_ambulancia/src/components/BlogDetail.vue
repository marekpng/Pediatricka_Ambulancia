<template>
    <div>
      <div v-if="loading">Loading...</div>
      <div v-else-if="blog">
        <h1>{{ blog.title }}</h1>
        <img v-if="blog.image" :src="getImageUrl(blog.image)" alt="Blog Image" />
        
        <div v-html="blog.content"></div>
      </div>
      <div v-else>
        <p>Blog post not found.</p>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        blog: null,
        loading: true,
        slug: "",
      };
    },
    mounted() {
      this.slug = this.$route.params.slug;
      this.fetchBlogPost();
    },
    methods: {
      async fetchBlogPost() {
        try {
          const response = await axios.get(`http://localhost/content-service/api/blog-posts/${this.slug}`);
          this.blog = response.data;
        } catch (error) {
          console.error("Error fetching blog post", error);
        } finally {
          this.loading = false;
        }
      },
      getImageUrl(imagePath) {
        return `http://localhost/content-service/storage/${imagePath}`;
      },
    },
  };
  </script>
  