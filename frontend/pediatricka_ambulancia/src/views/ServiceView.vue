<template>
  <!-- Page Header Start -->
  <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
      <h1 class="display-3 text-white mb-3 animated slideInDown">Services</h1>
      <nav aria-label="breadcrumb animated slideInDown">
        <ol class="breadcrumb text-uppercase mb-0">
          <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
          <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
          <li class="breadcrumb-item text-primary active" aria-current="page">Services</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- Page Header End -->


  <!-- Service Start -->
  <div class="container-xxl py-5">
    <div class="container">
      <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
        <p class="d-inline-block border rounded-pill py-1 px-4">Services</p>
        <h1>Health Care Solutions</h1>
      </div>
      <div class="row g-4">
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
          <div class="service-item bg-light rounded h-100 p-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
              <i class="fa fa-heartbeat text-primary fs-4"></i>
            </div>
            <h4 class="mb-3">Cardiology</h4>
            <p class="mb-4">Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet.</p>
            <a class="btn" href=""><i class="fa fa-plus text-primary me-3"></i>Read More</a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
          <div class="service-item bg-light rounded h-100 p-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
              <i class="fa fa-x-ray text-primary fs-4"></i>
            </div>
            <h4 class="mb-3">Pulmonary</h4>
            <p class="mb-4">Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet.</p>
            <a class="btn" href=""><i class="fa fa-plus text-primary me-3"></i>Read More</a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
          <div class="service-item bg-light rounded h-100 p-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
              <i class="fa fa-brain text-primary fs-4"></i>
            </div>
            <h4 class="mb-3">Neurology</h4>
            <p class="mb-4">Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet.</p>
            <a class="btn" href=""><i class="fa fa-plus text-primary me-3"></i>Read More</a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
          <div class="service-item bg-light rounded h-100 p-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
              <i class="fa fa-wheelchair text-primary fs-4"></i>
            </div>
            <h4 class="mb-3">Orthopedics</h4>
            <p class="mb-4">Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet.</p>
            <a class="btn" href=""><i class="fa fa-plus text-primary me-3"></i>Read More</a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
          <div class="service-item bg-light rounded h-100 p-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
              <i class="fa fa-tooth text-primary fs-4"></i>
            </div>
            <h4 class="mb-3">Dental Surgery</h4>
            <p class="mb-4">Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet.</p>
            <a class="btn" href=""><i class="fa fa-plus text-primary me-3"></i>Read More</a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
          <div class="service-item bg-light rounded h-100 p-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-4" style="width: 65px; height: 65px;">
              <i class="fa fa-vials text-primary fs-4"></i>
            </div>
            <h4 class="mb-3">Laboratory</h4>
            <p class="mb-4">Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet.</p>
            <a class="btn" href=""><i class="fa fa-plus text-primary me-3"></i>Read More</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Service End -->


  <!-- Appointment Start -->
  <AppointmentForm />
  <!-- Appointment End -->


  <!-- Testimonial Start -->


  <Testimonials />
  <!-- Testimonial End -->
</template>

<script>
import Testimonials from "@/components/Testimonials.vue";
import AppointmentForm from "@/components/AppointmentForm.vue";
export default {
  name: "ServiceView",
  components: {
    AppointmentForm,
    Testimonials
  }
}
</script>

<style scoped>
.page-header {
  background: url('/img/header-page.jpg') top center no-repeat;
}
a {

  text-decoration: none;
}
</style>