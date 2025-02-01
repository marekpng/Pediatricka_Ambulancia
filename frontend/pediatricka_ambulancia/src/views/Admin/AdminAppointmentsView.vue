   <template>
    <div class="appointments-container">
      <h1>Confirmed Appointments</h1>
  
    
      <div class="filter-section">
        <label for="filter-date" class="filter-label">Filter by Date</label>
        <select id="filter-date" class="filter-select" v-model="selectedDate" @change="filterAppointmentsByDate">
          <option value="" disabled>Select a date</option>
          <option v-for="date in availableDates" :value="date" :key="date">{{ date }}</option>
        </select>
      </div>
  
      <div v-if="filteredAppointments.length">
        <table class="appointments-table">
          <thead>
            <tr>
              <th>Patient Name</th>
              <th>Personal Number</th>
              <th>Email</th>
              <th>Contact</th>
              <th>Address</th>
              <th>Date</th>
              <th>Time</th>
              <th>Description</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="appointment in filteredAppointments" :key="appointment.id">
              <td data-label="Patient Name">{{ appointment.patient.name }}</td>
              <td data-label="Personal Number" class="personal-number" :title="appointment.patient.personal_number">
                {{ truncate(appointment.patient.personal_number) }}
              </td>
              <td data-label="Email">{{ appointment.email }}</td>
              <td data-label="Contact">{{ appointment.patient.contact_number }}</td>
              <td data-label="Address">{{ appointment.patient.address }}</td>
              <td data-label="Date">{{ appointment.timeslot.date }}</td>
              <td data-label="Time">
                {{ appointment.timeslot.start_time }} - {{ appointment.timeslot.end_time }}
              </td>
              <td data-label="Description">{{ appointment.description }}</td>
              <td data-label="Actions">
                <button class="btn btn-warning btn-sm" @click="editAppointment(appointment)">Edit</button>
                <button class="btn btn-danger btn-sm" @click="deleteAppointment(appointment.id)">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else>
        <p class="no-appointments">No confirmed appointments found for the selected date.</p>
      </div>
  
      <div v-if="editingAppointment" class="modal-overlay">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5>Edit Appointment</h5>
              <button type="button" class="close-btn" @click="cancelEdit">&times;</button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="saveAppointment">
                <div class="form-group">
                  <label for="edit-date" class="form-label">Date</label>
                  <select id="edit-date" class="form-control" v-model="editingAppointment.date" @change="fetchAvailableTimes" required>
                    <option value="" disabled>Select a date</option>
                    <option v-for="date in editingDates" :value="date" :key="date">{{ date }}</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="edit-time" class="form-label">Time</label>
                  <select id="edit-time" class="form-control" v-model="editingAppointment.time" :disabled="!availableTimes.length" required>
                    <option value="" disabled>Select a time</option>
                    <option v-for="timeslot in availableTimes" :value="timeslot" :key="timeslot.id">
                      {{ timeslot.start_time }} - {{ timeslot.end_time }}
                    </option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="edit-description" class="form-label">Description</label>
                  <textarea id="edit-description" class="form-control" v-model="editingAppointment.description" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary modal-save-btn">Save Changes</button>
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
        appointments: [],         
        filteredAppointments: [], 
        availableDates: [],       
        selectedDate: "",         
        availableTimes: [],       
        editingAppointment: null, 
        editingDates: []         
      };
    },
    methods: {
      truncate(value) {
        if (!value) return "";
        const sanitized = value.replace(/(\r\n|\n|\r)/gm, "");
        return sanitized.length > 10 ? sanitized.substring(0, 10) + "..." : sanitized;
      },
      fetchAppointments() {
        axios
          .get("http://localhost/reservation-service/api/admin/appointments", {
            headers: { Authorization: `Bearer ${localStorage.getItem("userToken")}` },
          })
          .then((response) => {
            this.appointments = response.data.filter(appointment => appointment.status === "confirmed"); 
            this.availableDates = [...new Set(this.appointments.map((appointment) => appointment.timeslot.date))];
            this.filteredAppointments = this.appointments;
          })
          .catch((error) => {
            console.error("Error fetching appointments:", error.response?.data || error);
          });
      },
      filterAppointmentsByDate() {
        this.filteredAppointments = this.selectedDate
          ? this.appointments.filter(appointment => appointment.timeslot.date === this.selectedDate)
          : this.appointments;
      },
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
        this.fetchEditingDates();
      },
      fetchEditingDates() {
        axios
          .get("http://localhost/reservation-service/api/schedule/timeslots/available")
          .then((response) => {
            const timeslots = response.data.available_timeslots;
            this.editingDates = [...new Set(timeslots.map((slot) => slot.date))];
            this.fetchAvailableTimes();
          })
          .catch((error) => {
            console.error("Error fetching available dates:", error.response?.data || error);
          });
      },
      fetchAvailableTimes() {
        if (!this.editingAppointment || !this.editingAppointment.date) return;
        axios
          .get("http://localhost/reservation-service/api/schedule/timeslots/available", {
            params: { start_date: this.editingAppointment.date, end_date: this.editingAppointment.date },
          })
          .then((response) => {
            const timeslots = response.data.available_timeslots;
            this.availableTimes = timeslots.filter(slot => slot.date === this.editingAppointment.date);
          })
          .catch((error) => {
            console.error("Error fetching available times:", error.response?.data || error);
          });
      },
      saveAppointment() {
        const updatedData = {
          timeslot_id: this.editingAppointment.time.id,
          description: this.editingAppointment.description,
        };
        axios
          .put(
            `http://localhost/reservation-service/api/admin/appointments/${this.editingAppointment.id}`,
            updatedData,
            { headers: { Authorization: `Bearer ${localStorage.getItem("userToken")}` } }
          )
          .then(() => {
            this.cancelEdit();
            this.fetchAppointments();
          })
          .catch((error) => {
            console.error("Error updating appointment:", error.response?.data || error);
          });
      },
      deleteAppointment(id) {
        axios
          .delete(`http://localhost/reservation-service/api/admin/appointments/${id}`, {
            headers: { Authorization: `Bearer ${localStorage.getItem("userToken")}` },
          })
          .then(() => {
            this.fetchAppointments();
          })
          .catch((error) => {
            console.error("Error deleting appointment:", error.response?.data || error);
          });
      },
      cancelEdit() {
        this.editingAppointment = null;
        this.availableTimes = [];
        this.editingDates = [];
      }
    },
    mounted() {
      this.fetchAppointments();
    }
  };
  </script>
 <style scoped>
 .appointments-container {
   max-width: 1200px;
   margin: 2rem auto;
   background: #fff;
   padding: 2rem;
   border-radius: 8px;
   box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
 }
 
 .appointments-container h1 {
   text-align: center;
   color: #333;
   margin-bottom: 2rem;
 }
 
 .filter-section {
   display: flex;
   flex-direction: column;
   align-items: center;
   margin-bottom: 2rem;
 }
 
 .filter-label {
   font-size: 1.1rem;
   font-weight: 600;
   color: #555;
   margin-bottom: 0.5rem;
 }
 
 .filter-select {
   width: 100%;
   max-width: 300px;
   padding: 0.75rem;
   border: 1px solid #ddd;
   border-radius: 4px;
   transition: border-color 0.3s ease;
 }
 
 .filter-select:focus {
   border-color: #007BFF;
   outline: none;
 }
 
 .appointments-table {
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 2rem;
 }
 
 .appointments-table th,
 .appointments-table td {
   padding: 1rem;
   text-align: left;
   border-bottom: 1px solid #ddd;
 }
 
 .appointments-table th {
   background-color: #f8f9fa;
   color: #333;
 }
 
 .personal-number {
   max-width: 150px;
   overflow: hidden;
   text-overflow: ellipsis;
   white-space: nowrap;
 }
 

 .btn {
   padding: 0.5rem 1rem;
   font-size: 0.9rem;
   border: none;
   border-radius: 4px;
   cursor: pointer;
   transition: background-color 0.3s ease, transform 0.2s ease;
   margin: 0.2rem;
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
   color: #fff;
 }
 
 .btn-danger:hover {
   background-color: #c82333;
 }
 
 .no-appointments {
   text-align: center;
   color: #777;
   font-size: 1.1rem;
   margin-top: 2rem;
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
   z-index: 1000;
   animation: fadeIn 0.3s;
 }
 
 @keyframes fadeIn {
   from { opacity: 0; }
   to { opacity: 1; }
 }
 
 .modal-dialog {
   width: 90%;
   max-width: 500px;
   margin: auto;
 }
 
 .modal-content {
   background: #fff;
   border-radius: 8px;
   overflow: hidden;
 }
 
 .modal-header {
   display: flex;
   justify-content: space-between;
   align-items: center;
   padding: 1rem;
   background-color: #f8f9fa;
   border-bottom: 1px solid #ddd;
 }
 
 .modal-header h5 {
   margin: 0;
   color: #333;
 }
 
 .close-btn {
   background: none;
   border: none;
   font-size: 1.5rem;
   cursor: pointer;
   color: #333;
 }
 
 .modal-body {
   padding: 1rem;
 }
 
 .form-group {
   margin-bottom: 1rem;
 }
 
 .form-label {
   font-weight: 600;
   color: #555;
   margin-bottom: 0.5rem;
   display: block;
 }
 
 .form-control {
   width: 100%;
   padding: 0.75rem;
   border: 1px solid #ddd;
   border-radius: 4px;
   transition: border-color 0.3s ease;
 }
 
 .form-control:focus {
   border-color: #007BFF;
   outline: none;
 }
 
 .modal-save-btn {
   width: 100%;
   padding: 0.75rem;
   font-size: 1rem;
   border: none;
   border-radius: 4px;
   cursor: pointer;
   background-color: #007BFF;
   color: #fff;
   transition: background-color 0.3s ease;
 }
 
 .modal-save-btn:hover {
   background-color: #0056b3;
 }
 
 @media (max-width: 768px) {
   .appointments-table, thead, tbody, th, td, tr {
     display: block;
   }
   .appointments-table thead tr {
     position: absolute;
     top: -9999px;
     left: -9999px;
   }
   .appointments-table tr {
     border: 1px solid #ddd;
     margin-bottom: 1rem;
   }
   .appointments-table td {
     border: none;
     border-bottom: 1px solid #ddd;
     position: relative;
     padding-left: 50%;
     text-align: right;
   }
   .appointments-table td::before {
     content: attr(data-label);
     position: absolute;
     left: 1rem;
     width: calc(50% - 2rem);
     text-align: left;
     font-weight: bold;
     color: #333;
   }
 }
 
 @media (max-width: 480px) {
   .modal-dialog {
     width: 95%;
     height: 95vh;
     margin: 0.5rem auto;
     display: flex;
     flex-direction: column;
   }
   .modal-content {
     flex: 1;
     overflow-y: auto;
     display: flex;
     flex-direction: column;
   }
   .modal-header, .modal-body {
     padding: 0.75rem;
   }
 }
 </style>  