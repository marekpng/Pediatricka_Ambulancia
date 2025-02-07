<template>

  <body>
  <!-- Header Start -->
  <div class="container-fluid header bg-primary p-0 mb-5">
    <div class="row g-0 align-items-center flex-column-reverse flex-lg-row">
      <div class="col-lg-6 p-5 wow fadeIn" data-wow-delay="0.1s">
        <h1 class="display-4 text-white mb-5">Byť zdravý je základ každého šťastia.</h1>
        <div class="row g-4">



<!--          Counter COMPONENT-->
          <div class="col-sm-4">
            <Counter :finalNumber="30" label="Rokov praxe."/>
          </div>
          <!-- <div class="col-sm-4">
            <Counter :finalNumber="1234" label="Medical Stuff"/>
          </div> -->
          <div class="col-sm-4">
            <Counter :finalNumber="1500" label="Celkový počet pacientov"/>
          </div>
<!--          Counter COMPONENT-->
        </div>
      </div>



      <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
    <div class="owl-carousel header-carousel">
      <div id="slider-internet" class="slider-container">
        <div class="slides-group">
          <div 
            v-for="(slide, index) in slides" 
            :key="index" 
            class="slide-internet" 
            v-show="index === current"
          >
            <div class="content-container">
              <img class="img-fluid" :src="'/img/' + slide.className" :alt="slide.specialization">
              <div class="text-container">
                <h1 class="display-1 text-white mb-0">{{ slide.specialization }}</h1>
              </div>
            </div>
          </div>
        </div>

        <button class="btn-internet btn-internet-prev" @click="prevSlide">&#10094;</button>
        <button class="btn-internet btn-internet-next" @click="nextSlide">&#10095;</button>

        <div class="dots-container">
          <span 
            v-for="(slide, index) in slides" 
            :key="'dot-' + index" 
            class="dot" 
            :class="{ active: index === current }"
            @click="goToSlide(index)"
          ></span>
        </div>
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
          <p class="d-inline-block border rounded-pill py-1 px-4">O nás</p>
          <h1 class="mb-4">Prečo by ste nám mali dôverovať? Spoznajte nás bližšie!</h1>
          <p>V našej pediatrickej ambulancii sa staráme o zdravie vašich detí s maximálnou odbornosťou a starostlivosťou. Na čele ambulancie stojí skúsený pediater, ktorý sa venuje diagnostike, prevencii a liečbe detských pacientov s individuálnym a láskavým prístupom. Pomáha mu tím troch kvalifikovaných zdravotných sestier, ktoré zabezpečujú plynulý chod ordinácie a starajú sa o pohodlie malých pacientov aj ich rodičov.</p>
          <p class="mb-4">Zakladáme si na kvalitnej zdravotnej starostlivosti, sledujeme najnovšie medicínske postupy a pristupujeme ku každému dieťaťu s porozumením a trpezlivosťou. Naším cieľom je, aby sa deti u nás cítili príjemne a rodičia mali istotu, že ich dieťa je v tých najlepších rukách.</p>
          <p><i class="far fa-check-circle text-primary me-3"></i>Kvalitná zdravotná starostlivosť</p>
          <p><i class="far fa-check-circle text-primary me-3"></i>Ľudský prístup</p>
          <p><i class="far fa-check-circle text-primary me-3"></i>Návšteva bez čakania</p>
          <!-- <a class="btn btn-primary rounded-pill py-3 px-5 mt-3" href="">Read More</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- About End -->

  <!-- Service Start -->
 <Service />
  <!-- Service End -->


  <!-- Feature Start -->
  <div class="container-fluid bg-primary overflow-hidden my-5 px-lg-0">
    <div class="container feature px-lg-0">
      <div class="row g-0 mx-lg-0">
        <div class="col-lg-6 feature-text py-5 wow fadeIn" data-wow-delay="0.1s">
          <div class="p-lg-5 ps-lg-0">
            <p class="d-inline-block border rounded-pill text-light py-1 px-4">Naše výhody</p>
            <h1 class="text-white mb-4">Prečo si vybrať práve nás</h1>
            <p class="text-white mb-4 pb-2">Naša pediatrická ambulancia ponúka odbornú starostlivosť pre deti od narodenia až po dospievanie. 
              S dlhoročnými skúsenosťami a individuálnym prístupom sa staráme o zdravie vašich najmenších.</p>
            <div class="row g-4">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                    <i class="fa fa-user-md text-primary"></i>
                  </div>
                  <div class="ms-4">
                    <p class="text-white mb-2">Dlhoročné</p>
                    <h5 class="text-white mb-0">Skúsenosti</h5>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                    <i class="fa fa-check text-primary"></i>
                  </div>
                  <div class="ms-4">
                    <p class="text-white mb-2">Kvalitná</p>
                    <h5 class="text-white mb-0">Starostlivosť</h5>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                    <i class="fa fa-comment-medical text-primary"></i>
                  </div>
                  <div class="ms-4">
                    <p class="text-white mb-2">Profesionálne</p>
                    <h5 class="text-white mb-0">Poradenstvo</h5>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-light" style="width: 55px; height: 55px;">
                    <i class="fa fa-smile text-primary"></i>
                  </div>
                  <div class="ms-4">
                    <p class="text-white mb-2">Prívetivý</p>
                    <h5 class="text-white mb-0">Prístup k deťom</h5>
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

  <Blogs />


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
import Blogs from "@/components/Blogs.vue";
import Service from "@/components/Service.vue";

export default {
  name: "IndexView",
  components: {
    Counter,
    Testimonials,
    Doctors,
    AppointmentForm,
    Blogs,
    Service

  },
  data () {

    return {
      current: 0,
      slides: [
        { className: "carousel-1.jpg", specialization: "cardiology" },
        { className: "carousel-2.jpg", specialization: "pediatric" },
        { className: "carousel-3.jpg", specialization: "neorology" }
      ],
      autoSlideInterval: null

    }
  },
  methods: {

    nextSlide() {
      this.current = (this.current + 1) % this.slides.length; 
    },
    prevSlide() {
      this.current = (this.current + this.slides.length - 1) % this.slides.length; 
    },
    goToSlide(index) {
      this.current = index;
    },
    startAutoSlide() {
      this.autoSlideInterval = setInterval(() => {
        this.nextSlide();
      }, 5000); 
    },
    stopAutoSlide() {
      clearInterval(this.autoSlideInterval);
    }

  },
  mounted() {
    this.show = true;
    this.startAutoSlide();
  },
  beforeUnmount() {
    this.stopAutoSlide();
  }
}
</script>

<style scoped>





#slider-internet {
  position: relative;
  overflow: hidden;
  border-radius: 12px;
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
  justify-content: center;
  height: 100%;
  position: relative;
}

.text-container {
  position: absolute;
  bottom: 20%;
  left: 50%;
  transform: translateX(-50%);
  color: white;
  text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
  text-align: center;
}

.btn-internet {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(0, 0, 0, 0.6);
  color: white;
  border: none;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  font-size: 22px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  transition: all 0.3s ease-in-out;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
  z-index: 10;
}

.btn-internet-prev {
  left: 15px;
}

.btn-internet-next {
  right: 15px;
}

.btn-internet:hover {
  background-color: rgba(255, 255, 255, 0.8);
  color: black;
  transform: scale(1.1);
}

.img-fluid {
  max-width: 100%;
  max-height: 100%;
  object-fit: cover;
  border-radius: 12px;
}

.dots-container {
  position: absolute;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 10px;
}

.dot {
  width: 12px;
  height: 12px;
  background-color: white;
  border-radius: 50%;
  cursor: pointer;
  transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
}

.dot.active {
  background-color: black;
  transform: scale(1.2);
}







</style>