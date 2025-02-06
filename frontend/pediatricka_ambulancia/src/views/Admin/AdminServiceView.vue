<template>
    <div class="admin-container">
      <h1 class="title">Manage Services</h1>
  
      <div class="form-container">
        <h2>{{ isEditing ? "Edit Service" : "Create New Service" }}</h2>
        <input v-model="title" class="input-field" placeholder="Enter Service Title" />
        <input v-model="icon" class="input-field" placeholder="Enter FontAwesome Icon (e.g., fa-brain)" />
        <textarea v-model="description" class="textarea-field" placeholder="Enter Service Description"></textarea>
  
        <div class="button-group">
          <button v-if="!isEditing" @click="createService" class="btn btn-primary">Create</button>
          <button v-if="isEditing" @click="updateService" class="btn btn-warning">Update</button>
          <button v-if="isEditing" @click="resetForm" class="btn btn-secondary">Cancel</button>
        </div>
      </div>
  
      <div class="service-list">
        <h2>Existing Services</h2>
        <div v-if="services.length === 0" class="no-data">No services available.</div>
        <div v-else class="grid-container">
          <div v-for="service in services" :key="service.id" class="service-card">
            <div class="service-content">
              <i :class="`fa ${service.icon} text-primary service-icon`"></i>
              <h4 class="service-title">{{ service.title }}</h4>
              <p class="service-description">{{ truncateText(service.description, 120) }}</p>
            </div>
            <div class="action-buttons">
              <button @click="editService(service)" class="btn btn-edit">Edit</button>
              <button @click="deleteService(service.id)" class="btn btn-delete">Delete</button>
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
        services: [],
        title: "",
        description: "",
        icon: "",
        isEditing: false,
        editingId: null,
        setLoading: null, 
      };
    },
    created() {
      this.setLoading = inject("setLoading"); 
    },
    async mounted() {
      await this.fetchServices();
    },
    methods: {
      getAuthHeaders() {
        return {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("userToken")}`,
          },
        };
      },
      async fetchServices() {
        if (this.setLoading) this.setLoading(true);
        try {
          const response = await axios.get("http://localhost/content-service/api/services", this.getAuthHeaders());
          this.services = response.data;
        } catch (error) {
          console.error("Error fetching services:", error.response?.data || error);
        } finally {
          if (this.setLoading) this.setLoading(false);
        }
      },
      async createService() {
        if (!this.title || !this.description || !this.icon) {
          alert("All fields are required.");
          return;
        }
        if (this.setLoading) this.setLoading(true);
        try {
          await axios.post(
            "http://localhost/content-service/api/services",
            { title: this.title, description: this.description, icon: this.icon },
            this.getAuthHeaders()
          );
          this.fetchServices();
          this.resetForm();
        } catch (error) {
          console.error("Error creating service:", error.response?.data || error);
        } finally {
          if (this.setLoading) this.setLoading(false);
        }
      },
      editService(service) {
        this.title = service.title;
        this.description = service.description;
        this.icon = service.icon;
        this.isEditing = true;
        this.editingId = service.id;
      },
      async updateService() {
        if (!this.title || !this.description || !this.icon) {
          alert("All fields are required.");
          return;
        }
        if (this.setLoading) this.setLoading(true);
        try {
          await axios.put(
            `http://localhost/content-service/api/services/${this.editingId}`,
            { title: this.title, description: this.description, icon: this.icon },
            this.getAuthHeaders()
          );
          this.fetchServices();
          this.resetForm();
        } catch (error) {
          console.error("Error updating service:", error.response?.data || error);
        } finally {
          if (this.setLoading) this.setLoading(false);
        }
      },
      async deleteService(id) {
        if (!confirm("Are you sure you want to delete this service?")) return;
        if (this.setLoading) this.setLoading(true);
        try {
          await axios.delete(`http://localhost/content-service/api/services/${id}`, this.getAuthHeaders());
          this.fetchServices();
        } catch (error) {
          console.error("Error deleting service:", error.response?.data || error);
        } finally {
          if (this.setLoading) this.setLoading(false);
        }
      },
      resetForm() {
        this.title = "";
        this.description = "";
        this.icon = "";
        this.isEditing = false;
        this.editingId = null;
      },
      truncateText(text, length) {
        return text.length > length ? text.substring(0, length) + "..." : text;
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
    height: 100px;
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
  
  .grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 15px;
  }
  
  .service-card {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
  }
  
  .service-icon {
    font-size: 40px;
    margin-bottom: 10px;
  }
  
  .service-title {
    font-weight: bold;
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
  
  .btn-delete {
    background-color: #dc3545;
    color: white;
  }
  
  @media (max-width: 768px) {
    .grid-container {
      grid-template-columns: 1fr;
    }
  }
  </style>
  