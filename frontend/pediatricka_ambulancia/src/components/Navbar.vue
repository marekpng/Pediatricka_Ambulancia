<template>
  <!-- Navbar Start -->
  <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn" data-wow-delay="0.1s">

    <RouterLink to="/" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
      <h1 class="m-0 text-primary"><i class="far fa-hospital me-3"></i>Klinik</h1>
    </RouterLink>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto p-4 p-lg-0">

        <RouterLink to="/" class="nav-item nav-link ">Home</RouterLink>


        <RouterLink to="about" class="nav-item nav-link ">About</RouterLink>

        <RouterLink to="service" class="nav-item nav-link ">Service</RouterLink>

        <RouterLink to="contact" class="nav-item nav-link ">Contact</RouterLink>
        <RouterLink to="login" class="nav-item nav-link ">Prihlasit sa</RouterLink>
        <RouterLink to="register" class="nav-item nav-link ">Registrovat sa</RouterLink>
      </div>

      <RouterLink to="/appointment" class="btn btn-primary clr rounded-0 py-4 px-lg-5 d-none d-lg-block">Appointment<i class="fa fa-arrow-right ms-3"></i></RouterLink>
    </div>
  </nav>
  <!-- Navbar End -->
</template>

<script>
export default {
  name: "Navbar"
}
</script>

<style scoped>
.router-link-active {
 color: #0d6efd;
}
.clr {
  color: #FFFFFF;
}
</style>