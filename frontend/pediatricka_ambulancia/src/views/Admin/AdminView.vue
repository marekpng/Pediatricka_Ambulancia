<template>
    <div class="container py-5">
      <h1 class="text-center mb-5">Admin Dashboard</h1>
      <div class="d-flex justify-content-center gap-3">
  
        <button class="btn btn-primary btn-lg" @click="navigateTo('admin/appointments')">Appointments</button>
        
       
        <button class="btn btn-secondary btn-lg" @click="navigateTo('admin/schedule')">Schedule</button>
        
        
        <button class="btn btn-danger btn-lg" @click="logout">Logout</button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "AdminDashboard",
    methods: {
      navigateTo(route) {
        this.$router.push(`/${route}`);
      },
      logout() {
        localStorage.removeItem("userToken");
        window.location.href = "/login";
      },
    },
    mounted() {
      const token = localStorage.getItem("userToken");
      if (!token) {
        window.location.href = "/login";
      }
    },
  };
  </script>
  
  <style scoped>
  .container {
    text-align: center;
  }
  button {
    min-width: 150px;
    padding: 15px;
    font-size: 18px;
  }
  </style>
  