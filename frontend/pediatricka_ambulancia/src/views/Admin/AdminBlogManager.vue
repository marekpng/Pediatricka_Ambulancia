<template>
    <div class="admin-container">
      <h1 class="title">Manage Blog Posts</h1>
  
      <div class="button-group">
        <button v-if="isEditing" @click="resetForm" class="btn btn-secondary">Create New Post</button>
      </div>
  
      <div class="form-container">
        <input v-model="title" class="input-field" placeholder="Enter blog title" />
  
        <vue-quill v-model:content="content" theme="snow" contentType="html" class="editor"></vue-quill>
  
        <input type="file" class="file-input" @change="handleFileUpload" />
  
        <div class="button-group">
          <button v-if="!isEditing" @click="createBlogPost" class="btn btn-primary">Create Blog Post</button>
          <button v-if="isEditing" @click="updateBlogPost" class="btn btn-warning">Update Blog Post</button>
        </div>
      </div>
  
      <div class="blog-list">
        <h2 class="sub-title">Existing Blog Posts</h2>
        <div v-if="blogPosts.length === 0" class="no-posts">No blog posts available.</div>
  
        <div v-for="blog in blogPosts" :key="blog.id" class="blog-card">
          <div class="blog-info">
            <h3 class="blog-title">{{ blog.title }}</h3>
            <p class="blog-content-preview">{{ truncateText(blog.content) }}</p>
          </div>
          <div class="action-buttons">
            <button @click="editBlogPost(blog)" class="btn btn-edit">Edit</button>
            <button @click="deleteBlogPost(blog.id)" class="btn btn-delete">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  import { QuillEditor } from "@vueup/vue-quill";
  import "@vueup/vue-quill/dist/vue-quill.snow.css"; 
  
  export default {
    components: {
      VueQuill: QuillEditor,
    },
    data() {
      return {
        blogPosts: [],
        title: "",
        content: "",
        image: null,
        isEditing: false,
        editingId: null,
        loading: false,
      };
    },
    mounted() {
      this.fetchBlogPosts();
    },
    methods: {
      async fetchBlogPosts() {
        try {
          this.loading = true;
          const response = await axios.get("http://localhost/content-service/api/blog-posts");
          this.blogPosts = response.data;
        } catch (error) {
          console.error("Error fetching blog posts:", error);
        } finally {
          this.loading = false;
        }
      },
      async createBlogPost() {
        try {
          const formData = new FormData();
          formData.append("title", this.title);
          formData.append("content", this.content);
          if (this.image) {
            formData.append("image", this.image);
          }
  
          await axios.post("http://localhost/content-service/api/blog-posts", formData);
          this.fetchBlogPosts();
          this.resetForm();
        } catch (error) {
          console.error("Error creating blog post:", error);
        }
      },
      editBlogPost(blog) {
        this.title = blog.title;
        this.content = blog.content;
        this.isEditing = true;
        this.editingId = blog.id;
      },
      async updateBlogPost() {
        try {
            if (!this.editingId) {
            console.error("No blog post selected for update.");
            return;
            }

            console.log("Updating post with ID:", this.editingId);
            console.log("Title:", this.title);
            console.log("Content:", this.content);

            if (!this.title.trim() || !this.content.trim()) {
            console.error("Title or content is empty. Cannot update.");
            return;
            }

            const formData = new FormData();
            formData.append("title", this.title);
            formData.append("content", this.content);
            
            if (this.image) {
            formData.append("image", this.image);
            } else {
            formData.append("image", ""); 
            }

            const response = await axios.post(
            `http://localhost/content-service/api/blog-posts/${this.editingId}?_method=POST`,
            formData
            );

            console.log("Blog post updated successfully", response.data);
            this.fetchBlogPosts();
            this.resetForm();
        } catch (error) {
            console.error(
            "Error updating blog post:",
            error.response ? error.response.data : error
            );
        }
        },

      async deleteBlogPost(id) {
        try {
          await axios.delete(`http://localhost/content-service/api/blog-posts/${id}`);
          this.fetchBlogPosts();
        } catch (error) {
          console.error("Error deleting blog post:", error);
        }
      },
      handleFileUpload(event) {
        this.image = event.target.files[0];
      },
      resetForm() {
        this.title = "";
        this.content = "";
        this.image = null;
        this.isEditing = false;
        this.editingId = null;
      },
      truncateText(content) {
        const strippedContent = content.replace(/(<([^>]+)>)/gi, "");
        return strippedContent.length > 100 ? strippedContent.substring(0, 100) + "..." : strippedContent;
      },
    },
  };
  </script>
  
  <style scoped>
  .admin-container {
    max-width: 800px;
    margin: auto;
    padding: 20px;
    font-family: "Arial", sans-serif;
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
  }
  
  .title {
    text-align: center;
    color: #343a40;
    font-size: 28px;
    margin-bottom: 20px;
  }
  
  .form-container {
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
  }
  
  .input-field {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
  }
  
  .editor {
    width: 100%;
    margin-bottom: 15px;
  }
  
  .file-input {
    margin-bottom: 15px;
  }
  
  .button-group {
    display: flex;
    gap: 10px;
  }
  
  .btn {
    padding: 10px 15px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    transition: background 0.3s ease-in-out;
  }
  
  .btn-primary {
    background-color: #007bff;
    color: white;
  }
  
  .btn-primary:hover {
    background-color: #0056b3;
  }
  
  .btn-warning {
    background-color: #ffc107;
    color: white;
  }
  
  .btn-warning:hover {
    background-color: #d39e00;
  }
  
  .btn-secondary {
    background-color: #6c757d;
    color: white;
  }
  
  .btn-secondary:hover {
    background-color: #545b62;
  }
  
  .blog-list {
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
  }
  
  .blog-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8f9fa;
    padding: 15px;
    margin: 10px 0;
    border-radius: 8px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
  }
  
  .action-buttons {
    display: flex;
    gap: 10px;
  }
  
  .btn-edit {
    background-color: #28a745;
    color: white;
  }
  
  .btn-edit:hover {
    background-color: #1e7e34;
  }
  
  .btn-delete {
    background-color: #dc3545;
    color: white;
  }
  
  .btn-delete:hover {
    background-color: #a71d2a;
  }
  </style>
  