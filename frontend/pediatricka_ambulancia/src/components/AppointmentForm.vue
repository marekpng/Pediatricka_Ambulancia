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

                <!-- New Email Field -->
                <div class="col-12">
                  <input 
                    type="email" 
                    class="form-control border-0" 
                    placeholder="Zadajte Váš email" 
                    style="height: 55px;" 
                    v-model="formData.email" 
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
import { inject } from "vue";

export default {
  name: "AppointmentForm",
  data() {
    return {
      formData: {
        name: "",
        contactNumber: "",
        email: "",
        date: "",
        time: null,
        description: "",
        personalNumber: "",
      },
      availableDates: [],
      availableTimes: [],
      errorMessage: "",
      setLoading: null, 
    };
  },
  created() {
    this.setLoading = inject("setLoading"); 
  },
  methods: {
    async fetchAvailableTimes() {
      if (this.setLoading) this.setLoading(true); 
      try {
        const response = await axios.get(
          "http://localhost/reservation-service/api/schedule/timeslots/available",
          { withCredentials: true }
        );
        const allTimeslots = response.data.available_timeslots;
        this.availableDates = [...new Set(allTimeslots.map((timeslot) => timeslot.date))];
        if (this.formData.date) {
          this.availableTimes = allTimeslots.filter(
            (timeslot) => timeslot.date === this.formData.date
          );
        }
      } catch (error) {
        console.error("Error fetching available times:", error.response?.data || error);
      } finally {
        if (this.setLoading) this.setLoading(false); 
      }
    },

    async submitForm() {
      if (!this.formData.time) {
        this.errorMessage = "Prosím vyberte si časový slot.";
        return;
      }

      const appointmentData = {
        name: this.formData.name,
        personal_number: this.formData.personalNumber,
        timeslot_id: this.formData.time.id,
        contact_number: this.formData.contactNumber,
        email: this.formData.email,
        description: this.formData.description,
      };

      if (this.setLoading) this.setLoading(true); 

      try {
        await axios.post("http://localhost/reservation-service/api/appointments", appointmentData, {
          headers: { "Content-Type": "application/json" },
        });

        console.log("Appointment created successfully");
        this.errorMessage = "";
        this.$router.push("/success-page"); 
      } catch (error) {
        if (error.response && error.response.status === 429) {
          this.errorMessage =
            "Príliš veľa pokusov. Prosím počkajte 10 minút kým budete môcť znova odoslať formulár.";
        } else if (error.response && error.response.status === 403) {
          this.errorMessage =
            "Nesprávne zadané informácie. Prosím skontrolujte Meno a rodné číslo ešte raz.";
        } else {
          this.errorMessage = "Skontrolujte prosím Vaše údaje či sú správne ešte raz.";
        }
        console.error("Error creating appointment:", error.response?.data || error);
      } finally {
        if (this.setLoading) this.setLoading(false); 
      }
    },
  },
  mounted() {
    this.fetchAvailableTimes();
  },
};
</script>

<style scoped>

</style>
