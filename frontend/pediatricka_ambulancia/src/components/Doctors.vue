<template>
  <div class="container-xxl py-5">
    <div class="container">
      <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
        <p class="d-inline-block border rounded-pill py-1 px-4">Náš tím</p>
        <h1>Náš skúsený pracovný personál</h1>
      </div>
      <div class="row g-4">
        <div 
          v-for="doctor in doctors" 
          :key="doctor.id" 
          class="col-lg-3 col-md-6 wow fadeInUp" 
          :data-wow-delay="`0.${doctor.id}s`"
        >
          <div 
            class="team-item position-relative rounded overflow-hidden"
            @mouseenter="hoverDoctor = doctor.id"
            @mouseleave="hoverDoctor = null"
            @click="openModal(doctor)"
            style="cursor: pointer;"
          >
            <div class="overflow-hidden position-relative">
              <img 
                :src="getDoctorImage(doctor.image)" 
                class="img-fluid doctor-image" 
                :alt="doctor.name"
              />
              <div 
                class="click-overlay"
                :class="{ 'hover-visible': hoverDoctor === doctor.id || isMobile }"
              >
                <p>📌 Kliknite pre viac informácií</p>
              </div>
            </div>
            <div 
              class="team-text bg-light text-center p-4"
              :class="{ 'overlay-text': hoverDoctor === doctor.id }"
            >
              <h5>{{ doctor.name }}</h5>
              <p class="text-primary">{{ doctor.department }}</p>
              <p v-if="hoverDoctor === doctor.id" class="description">{{ doctor.description }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div 
      class="modal fade" 
      id="doctorModal" 
      tabindex="-1" 
      aria-labelledby="doctorModalLabel" 
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="doctorModalLabel">{{ selectedDoctor?.name }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <img 
              v-if="selectedDoctor" 
              :src="getDoctorImage(selectedDoctor.image)" 
              class="img-fluid rounded mb-3"
              style="max-width: 300px; height: auto;"
            />
            <h4>{{ selectedDoctor?.department }}</h4>
            <p>{{ selectedDoctor?.description }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavrieť</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios';
import { Modal } from 'bootstrap';

export default {
  name: "Doctors",
  data() {
    return {
      doctors: [],
      hoverDoctor: null,
      selectedDoctor: null,
      modalInstance: null,
      isMobile: false,
    };
  },
  mounted() {
    this.fetchDoctors();
    this.modalInstance = new Modal(document.getElementById('doctorModal'));
    this.checkIfMobile();
    window.addEventListener("resize", this.checkIfMobile);
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.checkIfMobile);
  },
  methods: {
    async fetchDoctors() {
      try {
        const response = await axios.get('http://localhost/content-service/api/doctors');
        this.doctors = response.data;
      } catch (error) {
        console.error("There was an error fetching the doctors:", error);
      }
    },
    getDoctorImage(imagePath) {
      if (!imagePath) {
        return "/img/team-1.jpg"; 
      }
      return `http://localhost/content-service/${imagePath}`; 
    },
    openModal(doctor) {
      this.selectedDoctor = doctor;
      this.modalInstance.show();
    },
    checkIfMobile() {
      this.isMobile = window.innerWidth < 768;
    }
  }
};
</script>

<style scoped>

.team-item {
  transition: transform 0.3s ease-in-out;
}

.team-item:hover {
  transform: scale(1.05);
}


.doctor-image {
  width: 100%;
  height: 300px;
  object-fit: cover;
  transition: transform 0.3s ease-in-out;
}


.zoom-in {
  transform: scale(1.1);
}


.team-text {
  position: relative;
  transition: background 0.3s ease-in-out;
}

.overlay-text {
  background: rgba(0, 0, 0, 0.8);
  color: white;
}

.overlay-text h5,
.overlay-text p {
  color: black;
}


.click-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  background: rgba(0, 0, 0, 0.7);
  color: white;
  padding: 10px 0;
  text-align: center;
  font-size: 16px;
  font-weight: bold;
  transition: opacity 0.3s ease-in-out;
  opacity: 0; 
}


@media (max-width: 767px) {
  .click-overlay {
    opacity: 1;
  }
}

.hover-visible {
  opacity: 1;
}

.description {
  color: black;
}
</style>
