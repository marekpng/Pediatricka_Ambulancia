<template>
    <div class="container py-5">
      <h1>Appointments</h1>
  
      <!-- Date Filter -->
      <div class="mb-4">
        <label for="filter-date" class="form-label">Filter by Date</label>
        <select
          id="filter-date"
          class="form-control"
          v-model="selectedDate"
          @change="filterAppointmentsByDate"
        >
          <option value="" disabled>Select a date</option>
          <option v-for="date in availableDates" :value="date" :key="date">
            {{ date }}
          </option>
        </select>
      </div>
  
      <!-- List Appointments -->
      <div v-if="filteredAppointments.length">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Patient Name</th>
              <th>Personal Number</th>
              <th>Date</th>
              <th>Time</th>
              <th>Description</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="appointment in filteredAppointments" :key="appointment.id">
              <td>{{ appointment.patient.name }}</td>
              <td>{{ appointment.patient.personal_number }}</td>
              <td>{{ appointment.timeslot.date }}</td>
              <td>{{ appointment.timeslot.start_time }} - {{ appointment.timeslot.end_time }}</td>
              <td>{{ appointment.description }}</td>
              <td>
                <button class="btn btn-warning btn-sm" @click="editAppointment(appointment)">Edit</button>
                <button class="btn btn-danger btn-sm" @click="deleteAppointment(appointment.id)">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else>
        <p>No appointments found for the selected date.</p>
      </div>
  
      <!-- Edit Appointment Modal -->
      <div v-if="editingAppointment" class="modal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Appointment</h5>
              <button type="button" class="btn-close" @click="cancelEdit"></button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="saveAppointment">
                <!-- Select Date -->
                <div class="mb-3">
                  <label for="edit-date" class="form-label">Date</label>
                  <select
                    id="edit-date"
                    class="form-control"
                    v-model="editingAppointment.date"
                    @change="fetchAvailableTimes"
                    required
                  >
                    <option value="" disabled>Select a date</option>
                    <option v-for="date in availableDates" :value="date" :key="date">
                      {{ date }}
                    </option>
                  </select>
                </div>
  
                <!-- Select Time -->
                <div class="mb-3">
                  <label for="edit-time" class="form-label">Time</label>
                  <select
                    id="edit-time"
                    class="form-control"
                    v-model="editingAppointment.time"
                    :disabled="!availableTimes.length"
                    required
                  >
                    <option value="" disabled>Select a time</option>
                    <option
                      v-for="timeslot in availableTimes"
                      :value="timeslot"
                      :key="timeslot.id"
                    >
                      {{ timeslot.start_time }} - {{ timeslot.end_time }}
                    </option>
                  </select>
                </div>
  
                <!-- Edit Description -->
                <div class="mb-3">
                  <label for="edit-description" class="form-label">Description</label>
                  <textarea
                    id="edit-description"
                    class="form-control"
                    v-model="editingAppointment.description"
                    required
                  ></textarea>
                </div>
  
                <!-- Save Changes -->
                <button type="submit" class="btn btn-primary">Save Changes</button>
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
    name: "AdminAppointmentsView",
    data() {
      return {
        appointments: [], // All appointments
        filteredAppointments: [], // Appointments filtered by selected date
        availableDates: [], // Dates with available appointments
        selectedDate: "", // Currently selected date for filtering
        availableTimes: [], // Times for the selected date
        editingAppointment: null, // Currently editing appointment
      };
    },
    methods: {
      // Fetch all appointments
      fetchAppointments() {
        axios
          .get("http://127.0.0.1:8081/api/admin/appointments", {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("userToken")}`,
            },
          })
          .then((response) => {
            this.appointments = response.data;
  
            // Extract unique dates from appointments
            this.availableDates = [
              ...new Set(
                this.appointments.map((appointment) => appointment.timeslot.date)
              ),
            ];
  
            // Initially, show all appointments
            this.filteredAppointments = this.appointments;
          })
          .catch((error) => {
            console.error("Error fetching appointments:", error.response?.data || error);
          });
      },
  
      // Filter appointments by the selected date
      filterAppointmentsByDate() {
        if (this.selectedDate) {
          this.filteredAppointments = this.appointments.filter(
            (appointment) => appointment.timeslot.date === this.selectedDate
          );
        } else {
          this.filteredAppointments = this.appointments; // Show all if no date selected
        }
      },
  
      // Edit an appointment
      editAppointment(appointment) {
        this.editingAppointment = {
          id: appointment.id,
          description: appointment.description,
          date: appointment.timeslot.date,
          time: {
            id: appointment.timeslot.id,
            start_time: appointment.timeslot.start_time,
            end_time: appointment.timeslot.end_time,
          },
        };
  
        this.fetchAvailableDates(); // Fetch available dates for editing
      },
  
      // Fetch available dates
      fetchAvailableDates() {
        axios
          .get("http://127.0.0.1:8081/api/schedule/timeslots/available")
          .then((response) => {
            const timeslots = response.data.available_timeslots;
            this.availableDates = [...new Set(timeslots.map((slot) => slot.date))];
            this.fetchAvailableTimes(); // Automatically fetch times for the currently selected date
          })
          .catch((error) => {
            console.error("Error fetching available dates:", error.response?.data || error);
          });
      },
  
      // Fetch available times for the selected date
      fetchAvailableTimes() {
        if (!this.editingAppointment.date) return;
  
        axios
          .get("http://127.0.0.1:8081/api/schedule/timeslots/available", {
            params: { start_date: this.editingAppointment.date, end_date: this.editingAppointment.date },
          })
          .then((response) => {
            const timeslots = response.data.available_timeslots;
            this.availableTimes = timeslots.filter(
              (slot) => slot.date === this.editingAppointment.date
            );
          })
          .catch((error) => {
            console.error("Error fetching available times:", error.response?.data || error);
          });
      },
  
      // Save the updated appointment
      saveAppointment() {
        const updatedData = {
          timeslot_id: this.editingAppointment.time.id,
          description: this.editingAppointment.description,
        };
  
        axios
          .put(
            `http://127.0.0.1:8081/api/admin/appointments/${this.editingAppointment.id}`,
            updatedData,
            {
              headers: {
                Authorization: `Bearer ${localStorage.getItem("userToken")}`,
              },
            }
          )
          .then((response) => {
            console.log("Appointment updated:", response.data);
            this.editingAppointment = null;
            this.fetchAppointments(); // Refresh the list
          })
          .catch((error) => {
            console.error("Error updating appointment:", error.response?.data || error);
          });
      },
  
      // Delete an appointment
      deleteAppointment(id) {
        axios
          .delete(`http://127.0.0.1:8081/api/admin/appointments/${id}`, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("userToken")}`,
            },
          })
          .then((response) => {
            console.log("Appointment deleted:", response.data);
            this.fetchAppointments(); // Refresh the list
          })
          .catch((error) => {
            console.error("Error deleting appointment:", error.response?.data || error);
          });
      },
  
      // Cancel editing
      cancelEdit() {
        this.editingAppointment = null;
      },
    },
    mounted() {
      this.fetchAppointments();
    },
  };
  </script>
  
  <style>
  /* Modal styles */
  .modal {
    display: block;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    z-index: 1000;
  }
  .modal-dialog {
    width: 100%;
    max-width: 500px;
  }
  .modal-content {
    border: none;
    border-radius: 5px;
    overflow: hidden;
  }
  </style>
  