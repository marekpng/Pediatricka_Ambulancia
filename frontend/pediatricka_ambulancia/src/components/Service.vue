<template>
    <div class="container-xxl py-5">
      <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
          <p class="d-inline-block border rounded-pill py-1 px-4">Služby</p>
          <h1>Pediatrická starostlivosť pre vaše dieťa</h1>
        </div>
  
        <div v-if="loading" class="loading-container">
          <img src="../assets/medical-loader.gif" alt="Loading..." class="loading-gif" />
        </div>
  
        <div v-else class="row g-4">
          <div v-for="service in services" :key="service.id" class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="service-item bg-light rounded h-100 p-5">
              <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4"
                style="width: 65px; height: 65px;">
                <i :class="`fa ${service.icon} text-primary fs-4`"></i>
              </div>
              <h4 class="mb-3">{{ service.title }}</h4>
              <p class="mb-4">{{ service.description }}</p>
              <a class="btn" href="#"><i class="fa fa-plus text-primary me-3"></i>Read More</a>
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
        services: [],
        loading: true,
      };
    },
    async mounted() {
      await this.fetchServices();
    },
    methods: {
      async fetchServices() {
        try {
          const response = await axios.get("http://localhost/content-service/api/services");
          this.services = response.data;
        } catch (error) {
          console.error("Error fetching services:", error.response?.data || error);
        } finally {
          this.loading = false;
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .loading-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
  }
  
  .loading-gif {
    width: 80px;
    height: 80px;
  }
  
  .service-item {
    transition: transform 0.3s ease-in-out;
    cursor: pointer;
    text-align: center;
  }
  
  .service-item:hover {
    transform: scale(1.05);
  }
  
  .service-item .d-inline-flex i {
    font-size: 32px;
  }
  
  @media (max-width: 768px) {
    .service-item {
      padding: 15px;
    }
  }
  </style>
  