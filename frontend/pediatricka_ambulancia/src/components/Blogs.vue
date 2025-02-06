  

   <template>
    <div class="container-xxl py-5">
      <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
          <p class="d-inline-block border rounded-pill py-1 px-4">Blog</p>
          <h1>Najnovšie články</h1>
        </div>
        <div class="row g-4">
          <div v-for="blog in blogPosts" :key="blog.id" class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="blog-item bg-light rounded h-100 overflow-hidden">
             
              <div class="blog-img-container">
                <img v-if="blog.image" :src="getBlogImage(blog.image)" class="img-fluid" alt="Blog Image">
                <div v-else class="blog-placeholder">
                  <i class="fa fa-file-alt text-primary fs-4"></i>
                </div>
              </div>
              
              <div class="blog-content p-4 d-flex flex-column justify-content-between">
                <h4 class="mb-3">{{ blog.title }}</h4>
                <p class="mb-3 text-muted">{{ truncateText(blog.content) }}</p>
                <router-link :to="`/blog/${blog.slug}`" class="btn btn-primary">
                  <i class="fa fa-plus text-white me-2"></i> Čítať viac
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        blogPosts: [],
        loading: true,
      };
    },
    async mounted() {
      await this.fetchBlogPosts();
    },
    methods: {
      async fetchBlogPosts() {
        try {
          const response = await axios.get("http://localhost/content-service/api/blog-posts");
          this.blogPosts = response.data;
        } catch (error) {
          console.error("Error fetching blogs:", error);
        } finally {
          this.loading = false;
        }
      },
      getBlogImage(imagePath) {
        return imagePath ? `http://localhost/content-service/storage/${imagePath}` : "/img/default-blog.jpg";
      },
      truncateText(content) {
        const strippedContent = content.replace(/(<([^>]+)>)/gi, ""); 
        return strippedContent.length > 100 ? strippedContent.substring(0, 100) + "..." : strippedContent;
      },
    },
  };
  </script>
  
  <style scoped>

  .blog-item {
    transition: transform 0.3s ease-in-out;
    cursor: pointer;
    text-align: center;
    height: 100%; 
    display: flex;
    flex-direction: column;
  }
  
  .blog-item:hover {
    transform: scale(1.05);
  }
  
 
  .blog-img-container {
    width: 100%;
    height: 50%;
    overflow: hidden;
  }
  
  .blog-img-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  
  
  .blog-placeholder {
    width: 100%;
    height: 100%;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  

  .blog-content {
    height: 50%;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  

  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
  }
  
  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
  }
  </style>
  