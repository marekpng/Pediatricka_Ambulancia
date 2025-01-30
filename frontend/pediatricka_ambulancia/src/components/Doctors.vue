<!--<template>-->
<!--  &lt;!&ndash; Team Start &ndash;&gt;-->
<!--  <div class="container-xxl py-5">-->
<!--    <div class="container">-->
<!--      <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">-->
<!--        <p class="d-inline-block border rounded-pill py-1 px-4">Doctors</p>-->
<!--        <h1>Our Experience Doctors</h1>-->
<!--      </div>-->
<!--      <div class="row g-4">-->
<!--        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">-->
<!--          <div class="team-item position-relative rounded overflow-hidden">-->
<!--            <div class="overflow-hidden">-->
<!--              <img class="img-fluid" src="/img/team-1.jpg" alt="">-->
<!--            </div>-->
<!--            <div class="team-text bg-light text-center p-4">-->
<!--              <h5>Doctor Name</h5>-->
<!--              <p class="text-primary">Department</p>-->
<!--              <div class="team-social text-center">-->
<!--                <a class="btn btn-square" href=""><i class="fab fa-facebook-f"></i></a>-->
<!--                <a class="btn btn-square" href=""><i class="fab fa-twitter"></i></a>-->
<!--                <a class="btn btn-square" href=""><i class="fab fa-instagram"></i></a>-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
<!--        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">-->
<!--          <div class="team-item position-relative rounded overflow-hidden">-->
<!--            <div class="overflow-hidden">-->
<!--              <img class="img-fluid" src="/img/team-2.jpg" alt="">-->
<!--            </div>-->
<!--            <div class="team-text bg-light text-center p-4">-->
<!--              <h5>Doctor Name</h5>-->
<!--              <p class="text-primary">Department</p>-->
<!--              <div class="team-social text-center">-->
<!--                <a class="btn btn-square" href=""><i class="fab fa-facebook-f"></i></a>-->
<!--                <a class="btn btn-square" href=""><i class="fab fa-twitter"></i></a>-->
<!--                <a class="btn btn-square" href=""><i class="fab fa-instagram"></i></a>-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
<!--        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">-->
<!--          <div class="team-item position-relative rounded overflow-hidden">-->
<!--            <div class="overflow-hidden">-->
<!--              <img class="img-fluid" src="/img/team-3.jpg" alt="">-->
<!--            </div>-->
<!--            <div class="team-text bg-light text-center p-4">-->
<!--              <h5>Doctor Name</h5>-->
<!--              <p class="text-primary">Department</p>-->
<!--              <div class="team-social text-center">-->
<!--                <a class="btn btn-square" href=""><i class="fab fa-facebook-f"></i></a>-->
<!--                <a class="btn btn-square" href=""><i class="fab fa-twitter"></i></a>-->
<!--                <a class="btn btn-square" href=""><i class="fab fa-instagram"></i></a>-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
<!--        <div class="col-lg-3 col-md-6 wow fadeInUp" >-->
<!--          <div class="team-item position-relative rounded overflow-hidden">-->
<!--            <div class="overflow-hidden">-->
<!--              <img class="img-fluid" src="/img/team-4.jpg" alt="">-->
<!--            </div>-->
<!--            <div class="team-text bg-light text-center p-4">-->
<!--              <h5>Doctor Name</h5>-->
<!--              <p class="text-primary">Department</p>-->
<!--              <div class="team-social text-center">-->
<!--                <a class="btn btn-square" href=""><i class="fab fa-facebook-f"></i></a>-->
<!--                <a class="btn btn-square" href=""><i class="fab fa-twitter"></i></a>-->
<!--                <a class="btn btn-square" href=""><i class="fab fa-instagram"></i></a>-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--  &lt;!&ndash; Team End &ndash;&gt;-->
<!--</template>-->

<!--<script>-->
<!--export default {-->
<!--  name: "Doctors"-->
<!--}-->
<!--</script>-->

<!--<style scoped>-->

<!--</style>-->


<template>
  <div class="container-xxl py-5">
    <div class="container">
      <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
        <p class="d-inline-block border rounded-pill py-1 px-4">Doctors</p>
        <h1>Our Experienced Doctors</h1>
      </div>
      <div class="row g-4">
        <div v-for="doctor in doctors" :key="doctor.id" class="col-lg-3 col-md-6 wow fadeInUp" :data-wow-delay="`0.${index + 1}s`">
          <div class="team-item position-relative rounded overflow-hidden">
            <div class="overflow-hidden">
              <img :src="doctor.imagea || '/img/team-1.jpg'" class="img-fluid" :alt="doctor.name">
            </div>
            <div class="team-text bg-light text-center p-4">
              <h5>{{ doctor.name }}</h5>
              <p class="text-primary">{{ doctor.department }}</p>
              <div class="team-social text-center">
                <a class="btn btn-square" href="#"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-square" href="#"><i class="fab fa-twitter"></i></a>
                <a class="btn btn-square" href="#"><i class="fab fa-instagram"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "Doctors",
  data() {
    return {
      doctors: []
    };
  },
  created() {
    this.fetchDoctors();
  },
  methods: {
    fetchDoctors() {
      axios.get('http://localhost:8000/api/doctors')
          .then(response => {
            this.doctors = response.data;
          })
          .catch(error => {
            console.error("There was an error fetching the doctors:", error);
          });
    }
  }
}
</script>

<style scoped>
/* Add your styles here */
</style>
