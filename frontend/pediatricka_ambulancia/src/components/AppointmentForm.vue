<template>
  <div class="container-xxl py-5" id="appointment-form">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
          <p class="d-inline-block border rounded-pill py-1 px-4">Appointment</p>
          <h1 class="mb-4">Make An Appointment To Visit Our Doctor</h1>
          <p class="mb-4">Please select a date and time to book your appointment with the doctor.</p>
        </div>
        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
          <div class="bg-light rounded h-100 d-flex align-items-center p-5">
            <form @submit.prevent="submitForm">
              <div class="row g-3">
        
                <div class="col-12">
                  <input 
                    type="text" 
                    class="form-control border-0" 
                    placeholder="Vypľnte Vaše plné meno (Meno Priezvisko)" 
                    style="height: 55px;" 
                    v-model="formData.name" 
                    required>
                </div>

                <div class="col-12">
                  <input 
                    type="text" 
                    class="form-control border-0" 
                    placeholder="Kontaktné číslo (napr., +421 915 333 444)" 
                    style="height: 55px;" 
                    v-model="formData.contactNumber" 
                    required>
                </div>

                <div class="col-12">
                  <select 
                    class="form-control border-0" 
                    style="height: 55px;" 
                    v-model="formData.date" 
                    @change="fetchAvailableTimes" 
                    required>
                    <option value="" disabled>Vyberte dátum návštevy</option>
                    <option v-for="date in availableDates" :value="date" :key="date">
                      {{ date }}
                    </option>
                  </select>
                </div>

                <div class="col-12">
                  <select 
                    class="form-control border-0" 
                    style="height: 55px;" 
                    v-model="formData.time" 
                    :disabled="!availableTimes.length" 
                    required>
                    <option value="" disabled>Vyberte čas návštevy</option>
                    <option 
                      v-for="timeslot in availableTimes" 
                      :value="timeslot" 
                      :key="timeslot.id">
                      {{ timeslot.start_time }} - {{ timeslot.end_time }}
                    </option>
                  </select>
                </div>

                <div class="col-12">
                  <textarea 
                    class="form-control border-0" 
                    rows="5" 
                    placeholder="Popíšte Váš problém" 
                    v-model="formData.description" 
                    required>
                  </textarea>
                </div>

                <div class="col-12">
                  <input 
                    type="text" 
                    class="form-control border-0" 
                    placeholder="Vyplňte Vaše rodné číslo (e.g., 011128/0123)" 
                    style="height: 55px;" 
                    v-model="formData.personalNumber" 
                    required>
                </div>

                <div class="col-12" v-if="errorMessage">
                  <p class="text-danger">{{ errorMessage }}</p>
                </div>

                
                <div class="col-12">
                  <button 
                    class="btn btn-primary w-100 py-3" 
                    type="submit" 
                    :disabled="!availableTimes.length">
                    Book Appointment
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "AppointmentForm",
  data() {
    return {
      formData: {
        date: "",
        time: null, 
        description: "",
        name: "",
        personalNumber: "",
        contactNumber: "",
      },
      availableDates: [], 
      availableTimes: [], 
      errorMessage: "", 
    };
  },
  methods: {

    fetchAvailableTimes() {
      axios
        .get("http://localhost/reservation-service/api/schedule/timeslots/available", {
          withCredentials: true, 
        })
        .then((response) => {
          const allTimeslots = response.data.available_timeslots;

          this.availableDates = [
            ...new Set(allTimeslots.map((timeslot) => timeslot.date)),
          ];

          if (this.formData.date) {
            this.availableTimes = allTimeslots.filter(
              (timeslot) => timeslot.date === this.formData.date
            );
          }
        })
        .catch((error) => {
          console.error("Error fetching available times:", error.response?.data || error);
        });
    },

    
    submitForm() {
      if (!this.formData.time) {
        this.errorMessage = "Please select a time slot.";
        return;
      }

      const appointmentData = {
        name: this.formData.name,
        personal_number: this.formData.personalNumber,
        timeslot_id: this.formData.time.id, 
        contact_number: this.formData.contactNumber, 
        description: this.formData.description,
      };

      axios
        .post("http://127.0.0.1:8081/api/appointments", appointmentData, {
          headers: {
            "Content-Type": "application/json",
          },
        })
        .then((response) => {
          console.log("Appointment created successfully:", response.data);
          this.errorMessage = ""; 
          this.$router.push("/success-page"); 
        })
        .catch((error) => {
          if (error.response && error.response.status === 403) {
            this.errorMessage = "Nesprávne zadané informácie. Prosím skontrolujte Meno a rodné číslo ešte raz.";
          } else {
            this.errorMessage = "Skontrolujte prosím Vaše údaje či sú správne ešte raz.";
          }
          console.error("Error creating appointment:", error.response?.data || error);
        });
    },
  },
  mounted() {
    this.fetchAvailableTimes();
  },
};
</script>

<style scoped>
</style>
