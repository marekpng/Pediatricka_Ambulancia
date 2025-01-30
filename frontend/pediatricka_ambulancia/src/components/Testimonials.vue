
<template>
  <div class="slider-container">
    <div class="testimonial-item" v-for="(testimonial, index) in testimonials" :key="index"  v-show="index === currentSlide">
      <img class="img-fluid bg-light rounded-circle p-2 mx-auto mb-4" :src="testimonial.image" style="width: 100px; height: 100px;" alt="testimonial image">
      <div class="testimonial-text rounded text-center p-4">
        <p>{{ testimonial.quote }}</p>
        <h5 class="mb-1">{{ testimonial.name }}</h5>
        <span class="fst-italic">{{ testimonial.profession }}</span>
      </div>
    </div>

    <div class="swiper-button-prev" @click="prevSlide">
    </div>
    <div class="swiper-button-next" @click="nextSlide">
    </div>
  </div>
</template>
<script>




export default {
  name: "IndexView",
  components: {

  },
  data () {

    return {


      testimonials: [
        {
          name: "Miska Pastekova",
          profession: "Predavacka",
          quote: "Clita clita tempor justo dolor ipsum amet...",
          image: "../src/image/testimonial-1.jpg"
        },
        {
          name: "Jozko Mrkva",
          profession: "Kurier",
          quote: "Clita tempor tempor tempor tempor...",
          image: "../src/image/testimonial-2.jpg"
        },
        {
          name: "Ferdinand Remen",
          profession: "Ucitel",
          quote: "Clita clita clitaclita clitaclita clita...",
          image: "../src/image/testimonial-3.jpg"
        },

      ],
      currentSlide: 0,

    }
  },
  methods: {
    nextSlide() {
      this.currentSlide = (this.currentSlide + 1) % this.testimonials.length;
    },
    prevSlide() {
      this.currentSlide = (this.currentSlide + this.testimonials.length - 1) % this.testimonials.length;
    }
  },
  mounted() {
    setInterval(this.nextSlide, 5000); // Change slides every 5 seconds
  }

}
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

/* Container for your slider */
.slider-container {
  position: relative;

}

/* Common styles for prev and next buttons */
.swiper-button-prev,
.swiper-button-next {
  position: absolute;
  top: 50%; /* Center vertically */
  transform: translateY(-50%);
  background-color: #fff; /* Change as needed */
  border: 1px solid #ccc; /* Simple border */
  border-radius: 50%; /* Circular shape */
  width: 65px; /* Width of the button */
  height: 60px; /* Height of the button */
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

/* Style for the Previous button */
.swiper-button-prev {
  left: 10px; /* Adjust the position from the left */
}

/* Style for the Next button */
.swiper-button-next {
  right: 10px; /* Adjust the position from the right */
}

/* Style for buttons within the divs */
.swiper-button-prev button,
.swiper-button-next button {
  border: none;
  background-color: transparent;
  font-size: 20px; /* Adjust size of the arrow */
  cursor: pointer;
}

</style>