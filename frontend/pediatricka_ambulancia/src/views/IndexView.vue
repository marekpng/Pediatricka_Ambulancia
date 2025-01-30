<template>

  <body>
  <!-- Header Start -->
  <div class="container-fluid header bg-primary p-0 mb-5">
    <div class="row g-0 align-items-center flex-column-reverse flex-lg-row">
      <div class="col-lg-6 p-5 wow fadeIn" data-wow-delay="0.1s">
        <h1 class="display-4 text-white mb-5">Good Health Is The Root Of All Heppiness</h1>
        <div class="row g-4">



<!--          Counter COMPONENT-->
          <div class="col-sm-4">
            <Counter :finalNumber="123" label="Expert Doctors"/>
          </div>
          <div class="col-sm-4">
            <Counter :finalNumber="1234" label="Medical Stuff"/>
          </div>
          <div class="col-sm-4">
            <Counter :finalNumber="12345" label="Total Patients"/>
          </div>
<!--          Counter COMPONENT-->
        </div>
      </div>


      <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
        <div class="owl-carousel header-carousel">


          <div id="slider-internet" class="slider-container">
            <div class="slides-group">
              <div v-for="(slide, index) in slides" :key="index" class="slide-internet" v-show="index === current">
                <div class="content-container">
                  <img class="img-fluid" :src="'/img/' + slide.className" alt="">
                  <div class="text-container">
                    <h1 class="display-1 text-white mb-0">{{ slide.specialization }}</h1>
                  </div>
                </div>
              </div>
            </div>
            <div class="btn-internet btn-internet-prev" aria-label="Previous slide" @click="prevSlide">&#10094;</div>
            <div class="btn-internet btn-internet-next" aria-label="Next slide" @click="nextSlide">&#10095;</div>
          </div>




        </div>
      </div>

    </div>
  </div>
  <!-- Header End -->


  <!-- About Start -->
  <div class="container-xxl py-5">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
          <div class="d-flex flex-column">
            <img class="img-fluid rounded w-75 align-self-end" src="/img/about-1.jpg" alt="">
            <img class="img-fluid rounded w-50 bg-white pt-3 pe-3" src="/img/about-2.jpg" alt="" style="margin-top: -25%;">
          </div>
        </div>
        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
          <p class="d-inline-block border rounded-pill py-1 px-4">About Us</p>
          <h1 class="mb-4">Why You Should Trust Us? Get Know About Us!</h1>
          <p>Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna dolore erat amet</p>
          <p class="mb-4">Stet no et lorem dolor et diam, amet duo ut dolore vero eos. No stet est diam rebum amet diam ipsum. Clita clita labore, dolor duo nonumy clita sit at, sed sit sanctus dolor eos.</p>
          <p><i class="far fa-check-circle text-primary me-3"></i>Quality health care</p>
          <p><i class="far fa-check-circle text-primary me-3"></i>Only Qualified Doctors</p>
          <p><i class="far fa-check-circle text-primary me-3"></i>Medical Research Professionals</p>
          <a class="btn btn-primary rounded-pill py-3 px-5 mt-3" href="">Read More</a>
        </div>
      </div>
    </div>
  </div>
  <!-- About End -->

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


  <!-- Feature Start -->
  <div class="container-fluid bg-primary overflow-hidden my-5 px-lg-0">
    <div class="container feature px-lg-0">
      <div class="row g-0 mx-lg-0">
        <div class="col-lg-6 feature-text py-5 wow fadeIn" data-wow-delay="0.1s">
          <div class="p-lg-5 ps-lg-0">
            <p class="d-inline-block border rounded-pill text-light py-1 px-4">Features</p>
            <h1 class="text-white mb-4">Why Choose Us</h1>
            <p class="text-white mb-4 pb-2">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo erat amet</p>
            <div class="row g-4">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                    <i class="fa fa-user-md text-primary"></i>
                  </div>
                  <div class="ms-4">
                    <p class="text-white mb-2">Experience</p>
                    <h5 class="text-white mb-0">Doctors</h5>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                    <i class="fa fa-check text-primary"></i>
                  </div>
                  <div class="ms-4">
                    <p class="text-white mb-2">Quality</p>
                    <h5 class="text-white mb-0">Services</h5>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                    <i class="fa fa-comment-medical text-primary"></i>
                  </div>
                  <div class="ms-4">
                    <p class="text-white mb-2">Positive</p>
                    <h5 class="text-white mb-0">Consultation</h5>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                    <i class="fa fa-headphones text-primary"></i>
                  </div>
                  <div class="ms-4">
                    <p class="text-white mb-2">24 Hours</p>
                    <h5 class="text-white mb-0">Support</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 pe-lg-0 wow fadeIn" data-wow-delay="0.5s" style="min-height: 400px;">
          <div class="position-relative h-100">
            <img class="position-absolute img-fluid w-100 h-100" src="/img/feature.jpg" style="object-fit: cover;" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Feature End -->




  <Doctors />
  <!-- Team End -->




  <AppointmentForm />
  <!-- Appointment End -->






<Testimonials/>


  </body>

</template>

<script>

import Testimonials from "@/components/Testimonials.vue";
import Doctors from "@/components/Doctors.vue";
import AppointmentForm from "@/components/AppointmentForm.vue";
import Counter from "@/components/Counter.vue";

export default {
  name: "IndexView",
  components: {
    Counter,
    Testimonials,
    Doctors,
    AppointmentForm

  },
  data () {

    return {


      current: 0,

      // transitionName: "fade",
      // show: false,
      slides: [
        { className: "carousel-1.jpg", specialization: "cardiology" },
        { className: "carousel-2.jpg", specialization: "pediatric" },
        { className: "carousel-3.jpg", specialization: "neorology" }
      ],

    }
  },
  methods: {

    nextSlide() {
      this.current = (this.current + 1) % this.slides.length; // Posun na ďalší slide
    },
    prevSlide() {
      this.current = (this.current + this.slides.length - 1) % this.slides.length; // Posun na predchádzajúci slide
    },

  },
  mounted() {
    this.show = true;
  }
}
</script>

<style scoped>




.btn-internet {
  z-index: 10;
  cursor: pointer;
  border: 3px solid #fff;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 70px;
  height: 70px;
  position: absolute;
  top: calc(50% - 35px);
  left: 1%;
  transition: transform 0.3s ease-in-out;
  user-select: none;
}

.btn-internet-next {
  left: auto;
  right: 1%;
}

.btn-internet:hover {
  /*transform: scale();*/
  background-color: #4d4e52;
}

/*Koniec defaultu*/



/*Konzistentnejsie riesenie*/
#slider-internet {
  position: relative;
  overflow: hidden;
}

.slides-group {
  display: flex;
  width: 100%;
  height: 100%;
}

.slide-internet {
  flex: 0 0 100%;
  position: relative;
  text-align: center;
}

.content-container {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  height: 100%;
  position: relative;
}

.text-container {
  color: #000;
  padding: 20px;
  text-align: left;
  position: absolute;
  bottom: 25%;
  left: 50%;
  transform: translateX(-50%);
}

.img-fluid {
  max-width: 100%;
  max-height: 100%;
}

.btn-internet {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  font-size: 24px;
  cursor: pointer;
}

.btn-internet-prev {
  left: 10px;
}

.btn-internet-next {
  right: 10px;
}








</style>