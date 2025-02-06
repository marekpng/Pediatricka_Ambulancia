<template>
    <div class="admin-container">
      <h1 class="title">Patient Details</h1>
  
      <div v-if="loading" class="loading-overlay">
        <img src="../../assets/medical-loader.gif" alt="Loading..." class="loading-gif" />
      </div>
  
      <div v-if="patient">
        <div class="patient-info card">
          <h2>{{ patient.name }}</h2>
          <p><strong>Date of Birth:</strong> {{ patient.date_of_birth }}</p>
          <p><strong>Contact:</strong> {{ patient.contact_number }}</p>
          <p><strong>Address:</strong> {{ patient.address }}</p>
  
          <div class="button-group">
            <button @click="editMode = !editMode" class="btn btn-warning">
              {{ editMode ? "Cancel Edit" : "Edit Patient" }}
            </button>
            <button @click="deletePatient" class="btn btn-danger">Delete Patient</button>
          </div>
  
          <div v-if="editMode" class="edit-form">
            <input v-model="editData.name" class="input-field" placeholder="Enter Name" />
            <input v-model="editData.date_of_birth" type="date" class="input-field" />
            <input v-model="editData.contact_number" class="input-field" placeholder="Enter Phone Number" />
            <input v-model="editData.address" class="input-field" placeholder="Enter Address" />
            <button @click="updatePatient" class="btn btn-primary">Save Changes</button>
          </div>
        </div>
  
        <div class="appointments-section">
          <h2>Confirmed Appointments</h2>
          <button @click="fetchAppointments" class="btn btn-primary">Load Appointments</button>
  
          <div v-if="appointments.length === 0" class="no-data">No confirmed appointments.</div>
          <table v-else class="appointments-table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Email</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="appointment in appointments" :key="appointment.id">
                <td>{{ appointment.timeslot.date }}</td>
                <td>{{ appointment.timeslot.start_time }} - {{ appointment.timeslot.end_time }}</td>
                <td>{{ appointment.email }}</td>
                <td class="actions">
                  <button @click="editAppointment(appointment)" class="btn btn-warning btn-sm">Edit</button>
                  <button @click="deleteAppointment(appointment.id)" class="btn btn-danger btn-sm">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
  
      <div v-if="editAppointmentMode" class="modal-overlay">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5>Edit Appointment</h5>
              <button class="close-btn" @click="editAppointmentMode = false">&times;</button>
            </div>
            <div class="modal-body">
              <label>Select New Date:</label>
              <select v-model="selectedDate" class="input-field" @change="fetchAvailableTimes">
                <option value="" disabled>Select Date</option>
                <option v-for="date in availableDates" :value="date" :key="date">{{ date }}</option>
              </select>
  
              <label>Select New Time:</label>
              <select v-model="editAppointmentData.timeslot_id" class="input-field" :disabled="!availableTimes.length">
                <option value="" disabled>Select Time</option>
                <option v-for="slot in availableTimes" :value="slot.id" :key="slot.id">
                  {{ slot.start_time }} - {{ slot.end_time }}
                </option>
              </select>
  
              <button @click="updateAppointment" class="btn btn-primary modal-save-btn">Update Appointment</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        patient: null,
        appointments: [],
        availableDates: [],
        availableTimes: [],
        selectedDate: "",
        editMode: false,
        editAppointmentMode: false,
        editData: {
          name: "",
          date_of_birth: "",
          contact_number: "",
          address: "",
        },
        editAppointmentData: {},
        loading: false,
      };
    },
    async mounted() {
      await this.fetchPatient();
    },
    methods: {
      getAuthHeaders() {
        return {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("userToken")}`,
          },
        };
      },
      async fetchPatient() {
        this.loading = true;
        try {
          const response = await axios.get(
            `http://localhost/reservation-service/api/patients/${this.$route.params.id}`,
            this.getAuthHeaders()
          );
          this.patient = response.data;
          this.editData = { ...response.data };
        } catch (error) {
          console.error("Error fetching patient:", error);
        } finally {
          this.loading = false;
        }
      },
      async updatePatient() {
        this.loading = true;
        try {
          await axios.put(
            `http://localhost/reservation-service/api/patients/${this.patient.id}`,
            this.editData,
            this.getAuthHeaders()
          );
          this.patient = { ...this.editData };
          this.editMode = false;
        } catch (error) {
          console.error("Error updating patient:", error);
        } finally {
          this.loading = false;
        }
      },
      async deletePatient() {
        if (!confirm("Are you sure you want to delete this patient?")) return;
        this.loading = true;
        try {
          await axios.delete(
            `http://localhost/reservation-service/api/patients/${this.patient.id}`,
            this.getAuthHeaders()
          );
          this.$router.push("/admin/patient");
        } catch (error) {
          console.error("Error deleting patient:", error);
        } finally {
          this.loading = false;
        }
      },
      async fetchAppointments() {
        this.loading = true;
        try {
          const response = await axios.get(
            `http://localhost/reservation-service/api/patients/${this.patient.id}/appointments`,
            this.getAuthHeaders()
          );
          this.appointments = response.data;
        } catch (error) {
          console.error("Error fetching appointments:", error);
        } finally {
          this.loading = false;
        }
      },
      async fetchAvailableTimes() {
        try {
          this.availableTimes = [];
          this.availableDates = [];
  
          const response = await axios.get(
            "http://localhost/reservation-service/api/schedule/timeslots/available",
            this.getAuthHeaders()
          );
  
          if (Array.isArray(response.data.available_timeslots)) {
            const allTimeslots = response.data.available_timeslots;
  
            this.availableDates = [...new Set(allTimeslots.map((slot) => slot.date))];
  
            if (this.selectedDate) {
              this.availableTimes = allTimeslots.filter((slot) => slot.date === this.selectedDate);
            }
          } else {
            console.error("Unexpected API response:", response.data);
          }
        } catch (error) {
          console.error("Error fetching available times:", error);
        }
      },
      async updateAppointment() {
        this.loading = true;
        try {
          await axios.put(
            `http://localhost/reservation-service/api/appointments/${this.editAppointmentData.id}`,
            { timeslot_id: this.editAppointmentData.timeslot_id },
            this.getAuthHeaders()
          );
  
          this.editAppointmentMode = false;
          this.fetchAppointments();
        } catch (error) {
          console.error("Error updating appointment:", error);
        } finally {
          this.loading = false;
        }
      },
      editAppointment(appointment) {
        this.editAppointmentData = { ...appointment };
        this.selectedDate = appointment.timeslot.date;
        this.fetchAvailableTimes();
        this.editAppointmentMode = true;
      },
      async deleteAppointment(id) {
        if (!confirm("Are you sure you want to delete this appointment?")) return;
        this.loading = true;
        try {
          await axios.delete(
            `http://localhost/reservation-service/api/appointments/${id}`,
            this.getAuthHeaders()
          );
          this.fetchAppointments();
        } catch (error) {
          console.error("Error deleting appointment:", error);
        } finally {
          this.loading = false;
        }
      },
    },
  };
  </script>
  <style scoped>
  .admin-container {
    max-width: 1200px;
    margin: 2rem auto;
    background: #fff;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }
  
  h1 {
    text-align: center;
    color: #333;
    margin-bottom: 2rem;
  }
  
  .card {
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
  }
  
  .button-group {
    display: flex;
    gap: 10px;
    margin-top: 15px;
  }
  
  .btn {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  
  .btn:hover {
    transform: translateY(-2px);
  }
  
  .btn-warning {
    background-color: #ffc107;
    color: #212529;
  }
  
  .btn-warning:hover {
    background-color: #e0a800;
  }
  
  .btn-danger {
    background-color: #dc3545;
    color: white;
  }
  
  .btn-danger:hover {
    background-color: #c82333;
  }
  
  .appointments-section {
    margin-top: 2rem;
  }
  
  .appointments-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
  }
  
  .appointments-table th,
  .appointments-table td {
    padding: 1rem;
    border-bottom: 1px solid #ddd;
  }
  
  .appointments-table th {
    background-color: #f8f9fa;
    color: #333;
  }
  
  .actions {
    display: flex;
    gap: 10px;
  }
  
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .modal-dialog {
    width: 90%;
    max-width: 500px;
  }
  
  .modal-content {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  }
  
  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ddd;
  }
  
  .close-btn {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #333;
  }
  
  .modal-body {
    padding-top: 1rem;
  }
  
  .modal-save-btn {
    width: 100%;
    padding: 0.75rem;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
  }
  
  .modal-save-btn:hover {
    background-color: #0056b3;
  }
  
  @media (max-width: 768px) {
    .appointments-table,
    thead,
    tbody,
    th,
    td,
    tr {
      display: block;
    }
  
    .appointments-table tr {
      margin-bottom: 1rem;
      border: 1px solid #ddd;
    }
  }
  </style>
  