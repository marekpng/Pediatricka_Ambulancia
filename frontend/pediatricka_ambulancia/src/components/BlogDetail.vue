   <template>
    <div class="blog-container">
      <div v-if="loading" class="loading-container">
        <img src="../assets/medical-loader.gif" alt="Loading..." class="loading-gif" />
      </div>
  
      <div v-else-if="blog" class="blog-content">
        <h1 class="blog-title">{{ blog.title }}</h1>
        <div class="blog-text" v-html="blog.content"></div>
        <div class="blog-image-container">
          <img v-if="blog.image" :src="getImageUrl(blog.image)" alt="Blog Image" class="blog-image" />
        </div>
      </div>
  
      <div v-else class="error-message">Blog post not found.</div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  import { inject } from "vue";
  
  export default {
    data() {
      return {
        blog: null,
        loading: true,
        slug: "",
        setLoading: null,
      };
    },
    created() {
      this.setLoading = inject("setLoading"); 
    },
    mounted() {
      this.slug = this.$route.params.slug;
      this.fetchBlogPost();
    },
    methods: {
      async fetchBlogPost() {
        if (this.setLoading) this.setLoading(true);
        this.loading = true;
        try {
          const response = await axios.get(`http://localhost/content-service/api/blog-posts/${this.slug}`);
          this.blog = response.data;
        } catch (error) {
          console.error("Error fetching blog post", error);
        } finally {
          this.loading = false;
          if (this.setLoading) this.setLoading(false);
        }
      },
      getImageUrl(imagePath) {
        return `http://localhost/content-service/storage/${imagePath}`;
      },
    },
  };
  </script>
  
  <style scoped>
  .blog-container {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
  }
  
  .loading-container {
    text-align: center;
    padding: 50px 0;
  }
  
  .loading-gif {
    width: 100px;
    height: 100px;
  }
  
  .error-message {
    font-size: 20px;
    color: #555;
    text-align: center;
  }
  
  .blog-title {
    font-size: 32px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
  }
  
  .blog-text {
    text-align: justify;
    font-size: 18px;
    color: #444;
    line-height: 1.6;
    margin-bottom: 20px;
  }
  
  .blog-image-container {
    margin-top: 20px;
  }
  
  .blog-image {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
    border-radius: 10px;
  }
  
  @media (max-width: 768px) {
    .blog-container {
      max-width: 95%;
      margin: 20px auto;
      padding: 15px;
    }
  
    .blog-title {
      font-size: 28px;
    }
  
    .blog-text {
      font-size: 16px;
    }
  
    .blog-image {
      max-height: 300px;
    }
  }
  </style>
  