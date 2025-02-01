
<template>
  <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn" data-wow-delay="0.1s">
    <RouterLink to="/" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
      <h1 class="m-0 text-primary"><i class="far fa-hospital me-3"></i>Klinik</h1>
    </RouterLink>
    <button type="button" class="navbar-toggler me-4" @click="toggleNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" :class="{ show: isNavCollapsed }" id="navbarCollapse">
      <div class="navbar-nav ms-auto p-4 p-lg-0">
        <RouterLink to="/" class="nav-item nav-link" @click="closeNav">Home</RouterLink>
        <RouterLink to="about" class="nav-item nav-link" @click="closeNav">About</RouterLink>
        <RouterLink to="service" class="nav-item nav-link" @click="closeNav">Service</RouterLink>
        <RouterLink to="contact" class="nav-item nav-link" @click="closeNav">Contact</RouterLink>
        <RouterLink v-if="!isAdmin" to="login" class="nav-item nav-link" @click="closeNav">Prihlasit sa</RouterLink>
        <RouterLink v-if="!isAdmin" to="register" class="nav-item nav-link" @click="closeNav">Registrovat sa</RouterLink>
        
        <RouterLink v-if="isAdmin" to="/admin" class="nav-item nav-link" @click="closeNav">Admin</RouterLink>
      </div>
      <RouterLink to="/appointment" class="btn btn-primary clr rounded-0 py-4 px-lg-5 d-none d-lg-block">
        Appointment<i class="fa fa-arrow-right ms-3"></i>
      </RouterLink>
    </div>
  </nav>
</template>

<script>
export default {
  name: "Navbar",
  data() {
    return {
      isNavCollapsed: false,
    };
  },
  computed: {
    isAdmin() {
      return !!localStorage.getItem("userToken");
    },
  },
  methods: {
    toggleNav() {
      this.isNavCollapsed = !this.isNavCollapsed;
    },
    
    closeNav() {
      this.isNavCollapsed = false;
    },
  },
};
</script>

<style scoped>
.router-link-active {
  color: #0d6efd;
}
.clr {
  color: #FFFFFF;
}
</style>
