<template>
  <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
      <h1 class="display-3 text-white mb-3 animated slideInDown">Contact Us</h1>
      <nav aria-label="breadcrumb animated slideInDown">
        <ol class="breadcrumb text-uppercase mb-0">
          <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
          <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
          <li class="breadcrumb-item text-primary active" aria-current="page">Contact</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- Page Header End -->


  <!-- Contact Start -->
  <div class="container-xxl py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-4">
          <div class="h-100 bg-light rounded d-flex align-items-center p-5">
            <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-white" style="width: 55px; height: 55px;">
              <i class="fa fa-map-marker-alt text-primary"></i>
            </div>
            <div class="ms-4">
              <p class="mb-2">Address</p>
              <h5 class="mb-0">123 Street, New York, USA</h5>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="h-100 bg-light rounded d-flex align-items-center p-5">
            <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-white" style="width: 55px; height: 55px;">
              <i class="fa fa-phone-alt text-primary"></i>
            </div>
            <div class="ms-4">
              <p class="mb-2">Call Us Now</p>
              <h5 class="mb-0">+012 345 6789</h5>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="h-100 bg-light rounded d-flex align-items-center p-5">
            <div class="d-flex flex-shrink-0 align-items-center justify-content-center rounded-circle bg-white" style="width: 55px; height: 55px;">
              <i class="fa fa-envelope-open text-primary"></i>
            </div>
            <div class="ms-4">
              <p class="mb-2">Mail Us Now</p>
              <h5 class="mb-0">info@example.com</h5>
            </div>
          </div>
        </div>
        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
          <div class="bg-light rounded p-5">
            <p class="d-inline-block border rounded-pill py-1 px-4">Contact Us</p>
            <h1 class="mb-4">Have Any Query? Please Contact Us!</h1>
            <p class="mb-4">The contact form is currently inactive. Get a functional and working contact form with Ajax & PHP in a few minutes. Just copy and paste the files, add a little code and you're done. <a href="https://htmlcodex.com/contact-form">Download Now</a>.</p>
            <form>
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="name" placeholder="Your Name">
                    <label for="name">Your Name</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="email" class="form-control" id="email" placeholder="Your Email">
                    <label for="email">Your Email</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="subject" placeholder="Subject">
                    <label for="subject">Subject</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="Leave a message here" id="message" style="height: 100px"></textarea>
                    <label for="message">Message</label>
                  </div>
                </div>
                <div class="col-12">
                  <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
          <div class="h-100" style="min-height: 400px;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6311.507433025406!2d18.08243528873079!3d48.30935198874956!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476b3ee43b2f6763%3A0x75a567f979f5bed3!2sUniverzita%20Kon%C5%A1tant%C3%ADna%20Filozofa!5e0!3m2!1ssk!2ssk!4v1703251346183!5m2!1ssk!2ssk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Contact End -->


<!--  Tahanie udajov z localstorage-->
<!--  <div class="containerr">-->
<!--    <h2>Submissions View</h2>-->
<!--    <div class="grid-containerr">-->
<!--      <div v-for="(data, index) in allFormData" :key="index" class="boxx">-->
<!--        <h3>Submission {{ index + 1 }}</h3>-->
<!--        <p>Name: {{ data.name }}</p>-->
<!--        <p>Email: {{ data.email }}</p>-->
<!--        <p>Mobile: {{ data.mobile }}</p>-->
<!--        <p>Doctor: {{ data.doctor }}</p>-->
<!--        <p>Date: {{ data.date }}</p>-->
<!--        <p>Time: {{ data.time }}</p>-->
<!--        <p>Problem Description: {{ data.problemDescription }}</p>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->


  <div class="containerr">

    <h2>Vase objednanie u lekara</h2>
    <div v-if="isFormDataEmpty">
      <h3>Zatial ste sa neobjednali k lekarovi</h3>
    </div>
    <div v-else class="grid-containerr">
      <div class="boxx">
        <p>Meno: {{ formData.name }}</p>
        <p>Email: {{ formData.email }}</p>
        <p>Mobil: {{ formData.mobile }}</p>
        <p>Doktor: {{ formData.doctor }}</p>
        <p>Datum: {{ formData.date }}</p>
        <p>Cas: {{ formData.time }}</p>
        <p>Popis problemu: {{ formData.problemDescription }}</p>
      </div>
    </div>
  </div>


<!--TOTO JE PRE Computed reaktivnejsi a pomocou getteru zo storka-->
<!--      <div class="boxx">-->
<!--        <p>Meno: {{ allPatientData.name }}</p>-->
<!--        <p>Email: {{ allPatientData.email }}</p>-->
<!--        <p>Mobil: {{ allPatientData.mobile }}</p>-->
<!--        <p>Doktor: {{ allPatientData.doctor }}</p>-->
<!--        <p>Datum: {{ allPatientData.date }}</p>-->
<!--        <p>Cas: {{ allPatientData.time }}</p>-->
<!--        <p>Popis problemu: {{ allPatientData.problemDescription }}</p>-->
<!--      </div>-->


</template>

<script>
import { useStore } from '../stores/patient-form';


export default {
  name: "ContactView",
  data () {

    return {

      formData: {},
      isFormDataEmpty: true,
    };
  },
  mounted() {
    const allFormData = useStore();
    this.formData = allFormData.formData;
    this.isFormDataEmpty = !this.formData.name;
    // this.loadFormData();
  },


  // Sposob ktory je reaktivnejsi ale myslim si ze mounted je vhodnejsie pouzit lebo aj tak iba raz pristupim k tym datam
  // computed: {
  //   allPatientData() {
  //     const store = useStore();
  //     return store.getAllData;
  //   }
  // },
  methods: {
    // loadFormData() {
    //
    //   for (let i = 0; i < localStorage.length; i++) {
    //     const key = localStorage.key(i);
    //
    //
    //     if (key.startsWith('formData')) {
    //       const formData = JSON.parse(localStorage.getItem(key));
    //       this.allFormData.push(formData);
    //     }
    //   }
    // },
  }
}
</script>

<style scoped>
.page-header {
  background: url('/img/header-page.jpg') top center no-repeat;
}

.containerr {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.grid-containerr {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}

.boxx {
  flex: 1 1 calc(33.333% - 20px);
  border: 1px solid #ccc;
  padding: 20px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
  .boxx {
    flex-basis: calc(50% - 20px);
  }
}

@media (max-width: 480px) {
  .boxx {
    flex-basis: 100%;
  }
}
a {

  text-decoration: none;
}

</style>