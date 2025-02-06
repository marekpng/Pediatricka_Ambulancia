
   <template>
    <div class="admin-container">
      <h1 class="title">Manage Patients</h1>
  
      <div class="search-container">
        <input v-model="searchQuery" class="search-input" placeholder="Search by name..." @input="fetchPatients" />
        <button @click="showCreatePatientModal = true" class="btn btn-primary">Create Patient</button>
      </div>
  
      <div v-if="loading" class="loading-overlay">
        <img src="../../assets/medical-loader.gif" alt="Loading..." class="loading-gif" />
      </div>
  
      <div class="patients-list">
        <h2>Existing Patients</h2>
        <div v-if="patients.length === 0" class="no-data">No patients available.</div>
        <div v-else class="grid-container">
          <div v-for="patient in patients" :key="patient.id" class="patient-card" @click="viewPatient(patient.id)">
            <h4>{{ patient.name }}</h4>
            <p><strong>DOB:</strong> {{ patient.date_of_birth }}</p>
            <p><strong>Personal No.:</strong> {{ patient.personal_number }}</p>
            <p><strong>Contact:</strong> {{ patient.contact_number }}</p>
            <p><strong>Address:</strong> {{ patient.address }}</p>
          </div>
        </div>
  
        <div class="pagination">
          <button :disabled="!pagination.prev" @click="fetchPatients(pagination.prev)">Previous</button>
          <span>Page {{ pagination.current_page }} of {{ pagination.last_page }}</span>
          <button :disabled="!pagination.next" @click="fetchPatients(pagination.next)">Next</button>
        </div>
      </div>
  
      <div v-if="showCreatePatientModal" class="modal-overlay">
        <div class="modal-content">
          <h3>Create New Patient</h3>
          <input v-model="newPatient.name" class="input-field" placeholder="Enter Name" required />
          <input v-model="newPatient.date_of_birth" type="date" class="input-field" required />
          <input v-model="newPatient.personal_number" class="input-field" placeholder="Enter Personal Number" required />
          <input v-model="newPatient.contact_number" class="input-field" placeholder="Enter Contact Number" required />
          <input v-model="newPatient.address" class="input-field" placeholder="Enter Address" required />
  
          <button @click="createPatient" class="btn btn-primary">Create</button>
          <button @click="showCreatePatientModal = false" class="btn btn-secondary">Cancel</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        patients: [],
        searchQuery: "",
        pagination: { current_page: 1, last_page: 1, prev: null, next: null },
        loading: false,
        showCreatePatientModal: false,
        newPatient: {
          name: "",
          date_of_birth: "",
          personal_number: "",
          contact_number: "",
          address: "",
        },
      };
    },
    mounted() {
      this.fetchPatients();
    },
    methods: {
      getAuthHeaders() {
        return {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("userToken")}`,
          },
        };
      },
      async fetchPatients(url = "http://localhost/reservation-service/api/patients") {
        this.loading = true;
        try {
          const response = await axios.get(url, {
            ...this.getAuthHeaders(),
            params: { search: this.searchQuery },
          });
          this.patients = response.data.data;
          this.pagination = {
            current_page: response.data.current_page,
            last_page: response.data.last_page,
            prev: response.data.prev_page_url,
            next: response.data.next_page_url,
          };
        } catch (error) {
          console.error("Error fetching patients:", error);
        } finally {
          this.loading = false;
        }
      },
      viewPatient(id) {
        this.$router.push(`/admin/patients/${id}`);
      },
      async createPatient() {
        if (!this.newPatient.name || !this.newPatient.date_of_birth || !this.newPatient.personal_number) {
          alert("Name, Date of Birth, and Personal Number are required.");
          return;
        }
        this.loading = true;
        try {
          await axios.post(
            "http://localhost/reservation-service/api/patients",
            this.newPatient,
            this.getAuthHeaders()
          );
          this.showCreatePatientModal = false;
          this.fetchPatients();
          this.resetNewPatientForm();
        } catch (error) {
          console.error("Error creating patient:", error);
        } finally {
          this.loading = false;
        }
      },
      resetNewPatientForm() {
        this.newPatient = {
          name: "",
          date_of_birth: "",
          personal_number: "",
          contact_number: "",
          address: "",
        };
      },
    },
  };
  </script>
  
  <style scoped>
  .admin-container {
    max-width: 900px;
    margin: auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
  }
  
  .title {
    text-align: center;
    font-size: 28px;
    margin-bottom: 20px;
  }
  
  .search-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }
  
  .search-input {
    width: 70%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }
  
  .btn-primary {
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    border: none;
  }
  
  .btn-primary:hover {
    background-color: #0056b3;
  }
  
  .loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 15px;
  }
  
  .patient-card {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    cursor: pointer;
  }
  
  .patient-card:hover {
    background: #e9ecef;
  }
  
  .pagination {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
  }
  
  .pagination button {
    padding: 10px;
    border: none;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    cursor: pointer;
  }
  
  .pagination button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
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
  
  .modal-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    width: 400px;
  }
  
  .btn-secondary {
    background-color: #6c757d;
    color: white;
  }
  </style>
  