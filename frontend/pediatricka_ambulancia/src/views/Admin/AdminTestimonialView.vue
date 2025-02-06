<template>
    <div class="admin-container">
      <h1 class="title">Manage Testimonials</h1>
  
      <div v-if="loading" class="loading-overlay">
        <img src="../../assets/medical-loader.gif" alt="Loading..." class="loading-gif" />
      </div>
  
      <div class="form-container">
        <h2>{{ isEditing ? "Edit Testimonial" : "Create New Testimonial" }}</h2>
        <input v-model="name" class="input-field" placeholder="Enter Name" />
        <input v-model="profession" class="input-field" placeholder="Enter Profession" />
        <textarea v-model="quote" class="textarea-field" placeholder="Enter Testimonial Quote"></textarea>
  
        <div class="button-group">
          <button v-if="!isEditing" @click="createTestimonial" class="btn btn-primary">Create</button>
          <button v-if="isEditing" @click="updateTestimonial" class="btn btn-warning">Update</button>
          <button v-if="isEditing" @click="resetForm" class="btn btn-secondary">Cancel</button>
        </div>
      </div>
  
      <div class="testimonial-list">
        <h2>Existing Testimonials</h2>
        <div v-if="loading" class="loading-container">
          <img src="../../assets/medical-loader.gif" alt="Loading..." class="loading-gif" />
        </div>
        <div v-else-if="testimonials.length === 0" class="no-data">No testimonials available.</div>
        <div v-else class="grid-container">
          <div v-for="testimonial in testimonials" :key="testimonial.id" class="testimonial-card">
            <div class="testimonial-content">
              <h4>{{ testimonial.name }}</h4>
              <p class="profession">{{ testimonial.profession }}</p>
              <p class="quote">"{{ testimonial.quote }}"</p>
            </div>
            <div class="action-buttons">
              <button @click="editTestimonial(testimonial)" class="btn btn-edit">Edit</button>
              <button @click="deleteTestimonial(testimonial.id)" class="btn btn-delete">Delete</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  import { inject } from "vue";
  
  export default {
    data() {
      return {
        testimonials: [],
        name: "",
        profession: "",
        quote: "",
        isEditing: false,
        editingId: null,
        loading: false,
        setLoading: null,
      };
    },
    created() {
      this.setLoading = inject("setLoading"); 
    },
    async mounted() {
      await this.fetchTestimonials();
    },
    methods: {
      getAuthHeaders() {
        const token = localStorage.getItem("userToken");
        return {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        };
      },
      async fetchTestimonials() {
        if (this.setLoading) this.setLoading(true);
        this.loading = true;
        try {
          const response = await axios.get(
            "http://localhost/content-service/api/testimonials",
            this.getAuthHeaders()
          );
          this.testimonials = response.data;
        } catch (error) {
          console.error("Error fetching testimonials:", error.response?.data || error);
        } finally {
          this.loading = false;
          if (this.setLoading) this.setLoading(false);
        }
      },
      async createTestimonial() {
        this.loading = true;
        try {
          await axios.post(
            "http://localhost/content-service/api/testimonials",
            {
              name: this.name,
              profession: this.profession,
              quote: this.quote,
            },
            this.getAuthHeaders()
          );
          this.fetchTestimonials();
          this.resetForm();
        } catch (error) {
          console.error("Error creating testimonial:", error.response?.data || error);
        } finally {
          this.loading = false;
        }
      },
      editTestimonial(testimonial) {
        this.name = testimonial.name;
        this.profession = testimonial.profession;
        this.quote = testimonial.quote;
        this.isEditing = true;
        this.editingId = testimonial.id;
      },
      async updateTestimonial() {
        this.loading = true;
        try {
          await axios.put(
            `http://localhost/content-service/api/testimonials/${this.editingId}`,
            {
              name: this.name,
              profession: this.profession,
              quote: this.quote,
            },
            this.getAuthHeaders()
          );
          this.fetchTestimonials();
          this.resetForm();
        } catch (error) {
          console.error("Error updating testimonial:", error.response?.data || error);
        } finally {
          this.loading = false;
        }
      },
      async deleteTestimonial(id) {
        if (!confirm("Are you sure you want to delete this testimonial?")) return;
        this.loading = true;
        try {
          await axios.delete(
            `http://localhost/content-service/api/testimonials/${id}`,
            this.getAuthHeaders()
          );
          this.fetchTestimonials();
        } catch (error) {
          console.error("Error deleting testimonial:", error.response?.data || error);
        } finally {
          this.loading = false;
        }
      },
      resetForm() {
        this.name = "";
        this.profession = "";
        this.quote = "";
        this.isEditing = false;
        this.editingId = null;
      },
    },
  };
  </script>
  
  <style scoped>
  .admin-container {
    max-width: 900px;
    margin: auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    font-family: "Arial", sans-serif;
  }
  
  .title {
    text-align: center;
    color: #343a40;
    font-size: 28px;
    margin-bottom: 20px;
  }
  
  .form-container {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
  }
  
  .input-field,
  .textarea-field {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
  }
  
  .textarea-field {
    height: 80px;
  }
  
  .button-group {
    display: flex;
    gap: 10px;
    justify-content: center;
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
  
  .testimonial-list {
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
  }
  
  .testimonial-list h2 {
    margin-bottom: 20px;
  }
  
  .loading-container {
    text-align: center;
    padding: 20px;
  }
  
  .loading-gif {
    width: 80px;
    height: 80px;
  }
  
  .no-data {
    text-align: center;
    font-size: 18px;
    color: #666;
  }
  
  .grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 15px;
  }
  
  .testimonial-card {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
  }
  
  .testimonial-content {
    flex-grow: 1;
  }
  
  .profession {
    font-style: italic;
    color: #777;
  }
  
  .quote {
    font-size: 16px;
    color: #555;
    margin: 10px 0;
  }
  
  .action-buttons {
    display: flex;
    gap: 10px;
    margin-top: 10px;
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
  
  @media (max-width: 768px) {
    .grid-container {
      grid-template-columns: 1fr;
    }
  }
  </style>