<template>
  <div class="container-xxl py-5">
    <div class="container">
      <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
        <p class="d-inline-block border rounded-pill py-1 px-4">Povedali o nás</p>
      </div>
    </div>
  </div>
  <div class="slider-container">
    <div
      class="testimonial-item"
      v-for="(testimonial, index) in testimonials"
      :key="testimonial.id"
      v-show="index === currentSlide"
    >
      <div class="testimonial-text rounded text-center p-4">
        <h5 class="mb-1">{{ testimonial.name }}</h5>
        <p>{{ testimonial.quote }}</p>
        <!-- <span class="fst-italic">{{ testimonial.profession }}</span> -->
      </div>
    </div>

    <div class="swiper-button-prev" @click="prevSlide"></div>
    <div class="swiper-button-next" @click="nextSlide"></div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      testimonials: [],
      currentSlide: 0,
    };
  },
  async mounted() {
    await this.fetchTestimonials();
    setInterval(this.nextSlide, 5000);
  },
  methods: {
    async fetchTestimonials() {
      try {
        const response = await axios.get("http://localhost/content-service/api/testimonials");
        this.testimonials = response.data;
      } catch (error) {
        console.error("Error fetching testimonials:", error);
      }
    },
    nextSlide() {
      this.currentSlide = (this.currentSlide + 1) % this.testimonials.length;
    },
    prevSlide() {
      this.currentSlide = (this.currentSlide + this.testimonials.length - 1) % this.testimonials.length;
    }
  }
};
</script>


<style scoped>
@import 'swiper/swiper-bundle.css';




.testimonial-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
  transition: transform 0.5s ease, opacity 0.5s ease;

}


.testimonial-text {
  margin-top: 20px;
  background: #f8f9fa;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.slider-container {
  position: relative;

}

.swiper-button-prev,
.swiper-button-next {
  position: absolute;
  top: 50%; 
  transform: translateY(-50%);
  background-color: #fff;
  border: 1px solid #ccc; 
  border-radius: 50%; 
  width: 65px;
  height: 60px; 
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.swiper-button-prev {
  left: 10px; 
}


.swiper-button-next {
  right: 10px; 
}

.swiper-button-prev button,
.swiper-button-next button {
  border: none;
  background-color: transparent;
  font-size: 20px; 
  cursor: pointer;
}

</style>