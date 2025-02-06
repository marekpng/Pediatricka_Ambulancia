<template>
    <div class="container py-4">
      <h2 class="text-center mb-4">Manage Doctors</h2>
  
      <div class="card shadow-sm mb-4">
        <div class="card-header">
          <h5 class="mb-0">{{ doctor.id ? "Update Doctor" : "Create Doctor" }}</h5>
        </div>
        <div class="card-body">
          <form @submit.prevent="submitForm">
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" v-model="doctor.name" class="form-control" placeholder="Enter doctor's name" required />
            </div>
  
            <div class="mb-3">
              <label class="form-label">Department</label>
              <input type="text" v-model="doctor.department" class="form-control" placeholder="Enter department" required />
            </div>
  
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea v-model="doctor.description" class="form-control" rows="3" placeholder="Enter description"></textarea>
            </div>
  
            <div class="mb-3">
              <label class="form-label">Upload Image</label>
              <input type="file" @change="handleImageUpload" class="form-control" />
              <div v-if="previewImage" class="mt-3">
                <img :src="previewImage" alt="Doctor Preview" class="img-thumbnail" style="max-width: 150px;" />
              </div>
            </div>
  
            <button type="submit" class="btn btn-primary w-100">
              {{ doctor.id ? "Update" : "Create" }} Doctor
            </button>
            <button v-if="doctor.id" @click="resetForm" type="button" class="btn btn-secondary w-100 mt-2">Cancel</button>
          </form>
        </div>
      </div>
  
      <div v-if="doctors.length" class="card shadow-sm">
        <div class="card-header">
          <h5 class="mb-0">Existing Doctors</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div v-for="d in doctors" :key="d.id" class="col-md-6 col-lg-4 mb-3">
              <div class="card h-100">
                <img 
                    :src="getDoctorImage(d.image)"
                    class="card-img-top" 
                    alt="Doctor Image" 
                    style="max-height: 200px; object-fit: cover;"
                />
                
                <div class="card-body">
                  <h6 class="card-title">{{ d.name }}</h6>
                  <p class="text-muted">{{ d.department }}</p>
                  <div class="d-flex justify-content-between">
                    <button @click="editDoctor(d)" class="btn btn-warning btn-sm">Edit</button>
                    <button @click="confirmDelete(d.id)" class="btn btn-danger btn-sm">Delete</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <div v-if="showDeleteModal" class="modal fade show d-block">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Confirm Deletion</h5>
              <button type="button" class="btn-close" @click="showDeleteModal = false"></button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this doctor? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
              <button @click="deleteDoctor" class="btn btn-danger">Yes, Delete</button>
              <button @click="showDeleteModal = false" class="btn btn-secondary">Cancel</button>
            </div>
          </div>
        </div>
      </div>
      <div v-if="showDeleteModal" class="modal-backdrop fade show"></div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  import { inject } from "vue";
  
  export default {
    data() {
      return {
        doctors: [],
        doctor: { name: "", department: "", description: "", image: null },
        previewImage: null,
        showDeleteModal: false,
        deleteId: null,
        setLoading: null,
      };
    },
    created() {
      this.setLoading = inject("setLoading");
      this.fetchDoctors();
    },
    methods: {
      async fetchDoctors() {
        if (this.setLoading) this.setLoading(true);
        try {
          const response = await axios.get("http://localhost/content-service/api/doctors", {
            headers: { Authorization: `Bearer ${localStorage.getItem("userToken")}` },
          });
          this.doctors = response.data;
        } catch (error) {
          console.error("Error fetching doctors:", error.response?.data || error);
        } finally {
          if (this.setLoading) this.setLoading(false);
        }
      },
  
      handleImageUpload(event) {
        const file = event.target.files[0];
        this.doctor.image = file;
        this.previewImage = URL.createObjectURL(file);
      },
  
      async submitForm() {
        if (this.setLoading) this.setLoading(true);
        try {
          const formData = new FormData();
          formData.append("name", this.doctor.name);
          formData.append("department", this.doctor.department);
          formData.append("description", this.doctor.description);
          if (this.doctor.image) {
            formData.append("image", this.doctor.image);
          }
  
          const url = this.doctor.id
            ? `http://localhost/content-service/api/doctors/${this.doctor.id}`
            : "http://localhost/content-service/api/doctors";
          const method = this.doctor.id ? "post" : "post";
  
          await axios({
            method,
            url,
            data: formData,
            headers: {
              "Content-Type": "multipart/form-data",
              Authorization: `Bearer ${localStorage.getItem("userToken")}`,
            },
          });
  
          this.fetchDoctors();
          this.resetForm();
        } catch (error) {
          console.error("Error saving doctor:", error.response?.data || error);
        } finally {
          if (this.setLoading) this.setLoading(false);
        }
      },
  
      editDoctor(d) {
        this.doctor = { ...d };
        this.previewImage = d.image;
      },
  
      confirmDelete(id) {
        this.showDeleteModal = true;
        this.deleteId = id;
      },
  
      async deleteDoctor() {
        if (this.setLoading) this.setLoading(true);
        try {
          await axios.delete(`http://localhost/content-service/api/doctors/${this.deleteId}`, {
            headers: { Authorization: `Bearer ${localStorage.getItem("userToken")}` },
          });
          this.fetchDoctors();
          this.showDeleteModal = false;
        } catch (error) {
          console.error("Error deleting doctor:", error.response?.data || error);
        } finally {
          if (this.setLoading) this.setLoading(false);
        }
      },
  
      resetForm() {
        this.doctor = { name: "", department: "", description: "", image: null };
        this.previewImage = null;
      },

      getDoctorImage(imagePath) {
      if (!imagePath) {
        return "/img/team-1.jpg"; 
      }
      return `http://localhost/content-service/${imagePath}`; 
    }
    },
  };
  </script>
  