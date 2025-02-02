<template>
    <div class="container py-5">
      <h1>Manage Schedules</h1>
  
      <section v-if="Object.keys(groupedSchedules).length" class="mb-5">
        <h2>Select Year</h2>
        <div class="row">
          <div
            v-for="year in Object.keys(groupedSchedules)"
            :key="year"
            class="col-md-3 mb-3"
          >
            <button
              class="btn btn-primary w-100"
              @click="selectYear(year)"
            >
              {{ year }}
            </button>
          </div>
        </div>
      </section>
  
      <section v-if="selectedYear" class="mb-5">
        <h2>Select Month for {{ selectedYear }}</h2>
        <div class="row">
          <div
            v-for="month in Object.keys(groupedSchedules[selectedYear])"
            :key="month"
            class="col-md-3 mb-3"
          >
            <button
              class="btn btn-primary w-100"
              @click="selectMonth(month)"
            >
              {{ month }}
            </button>
          </div>
        </div>
      </section>
  
      <section v-if="selectedMonth" class="mb-5">
        <h2>Select Date for {{ selectedMonth }}, {{ selectedYear }}</h2>
        <div class="row">
          <div
            v-for="date in Object.keys(groupedSchedules[selectedYear][selectedMonth])"
            :key="date"
            class="col-md-3 mb-3"
          >
            <button
              class="btn btn-primary w-100"
              @click="selectDate(date)"
            >
              {{ date }}
            </button>
          </div>
        </div>
      </section>
  
      <section v-if="selectedDate" class="mb-5">
        <h2>Working Hours for {{ selectedDate }}</h2>
        <ul class="list-group">
          <li
            v-for="timeslot in groupedSchedules[selectedYear][selectedMonth][selectedDate]"
            :key="timeslot.id"
            class="list-group-item d-flex justify-content-between align-items-center"
          >
            <div>
              {{ timeslot.start_time }} - {{ timeslot.end_time }}
              <span
                v-if="timeslot.is_booked"
                class="badge bg-success ms-2"
              >
                Booked
              </span>
              <span
                v-else
                class="badge bg-warning ms-2"
              >
                Available
              </span>
            </div>
            <div>
              <button
                class="btn btn-warning btn-sm me-2"
                @click="editTimeslot(timeslot)"
                :disabled="timeslot.is_booked"
              >
                Edit
              </button>
              <button
                class="btn btn-danger btn-sm"
                @click="deleteTimeslot(timeslot.id)"
                :disabled="timeslot.is_booked"
              >
                Delete
              </button>
            </div>
          </li>
        </ul>
      </section>
  
      <div v-if="editingTimeslot" class="modal d-block">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Timeslot</h5>
              <button type="button" class="btn-close" @click="cancelEdit"></button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="saveTimeslot">
                <div class="mb-3">
                  <label for="edit-date" class="form-label">Date</label>
                  <input
                    type="date"
                    id="edit-date"
                    class="form-control"
                    v-model="editingTimeslot.date"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="edit-start-time" class="form-label">Start Time</label>
                  <input
                    type="time"
                    id="edit-start-time"
                    class="form-control"
                    v-model="editingTimeslot.start_time"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="edit-end-time" class="form-label">End Time</label>
                  <input
                    type="time"
                    id="edit-end-time"
                    class="form-control"
                    v-model="editingTimeslot.end_time"
                    required
                  />
                </div>
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
import { inject } from "vue";

export default {
  name: "ManageSchedules",
  data() {
    return {
      schedules: [],
      groupedSchedules: {},
      selectedYear: null,
      selectedMonth: null,
      selectedDate: null,
      editingTimeslot: null,
      setLoading: null, 
    };
  },
  created() {
    this.setLoading = inject("setLoading"); 
  },
  methods: {
    async fetchSchedules() {
      if (this.setLoading) this.setLoading(true);
      try {
        const response = await axios.get("http://localhost/reservation-service/api/schedule/all", {
          headers: { Authorization: `Bearer ${localStorage.getItem("userToken")}` },
        });
        this.schedules = response.data.timeslots;
        this.groupSchedules();
      } catch (error) {
        console.error("Error fetching schedules:", error.response?.data || error);
      } finally {
        if (this.setLoading) this.setLoading(false);
      }
    },

    groupSchedules() {
      this.groupedSchedules = this.schedules.reduce((acc, timeslot) => {
        const year = new Date(timeslot.date).getFullYear();
        const month = new Date(timeslot.date).toLocaleString("default", { month: "long" });
        const date = timeslot.date;

        if (!acc[year]) acc[year] = {};
        if (!acc[year][month]) acc[year][month] = {};
        if (!acc[year][month][date]) acc[year][month][date] = [];

        acc[year][month][date].push(timeslot);
        return acc;
      }, {});
    },

    selectYear(year) {
      this.selectedYear = year;
      this.selectedMonth = null;
      this.selectedDate = null;
    },

    selectMonth(month) {
      this.selectedMonth = month;
      this.selectedDate = null;
    },

    selectDate(date) {
      this.selectedDate = date;
    },

    editTimeslot(timeslot) {
      this.editingTimeslot = { ...timeslot };
    },

    async saveTimeslot() {
      if (this.setLoading) this.setLoading(true);
      try {
        const formattedStartTime = `${this.editingTimeslot.start_time}:00`;
        const formattedEndTime = `${this.editingTimeslot.end_time}:00`;

        await axios.put(
          `http://localhost/reservation-service/api/schedule/timeslots/${this.editingTimeslot.id}`,
          {
            date: this.editingTimeslot.date,
            start_time: formattedStartTime,
            end_time: formattedEndTime,
          },
          {
            headers: { Authorization: `Bearer ${localStorage.getItem("userToken")}` },
          }
        );

        this.editingTimeslot = null;
        await this.fetchSchedules();
      } catch (error) {
        console.error("Error updating timeslot:", error.response?.data || error);
      } finally {
        if (this.setLoading) this.setLoading(false);
      }
    },

    async deleteTimeslot(id) {
      if (this.setLoading) this.setLoading(true);
      try {
        await axios.delete(`http://localhost/reservation-service/api/schedule/timeslots/${id}`, {
          headers: { Authorization: `Bearer ${localStorage.getItem("userToken")}` },
        });
        await this.fetchSchedules();
      } catch (error) {
        console.error("Error deleting timeslot:", error.response?.data || error);
      } finally {
        if (this.setLoading) this.setLoading(false);
      }
    },

    cancelEdit() {
      this.editingTimeslot = null;
    },
  },
  async mounted() {
    await this.fetchSchedules();
  },
};
</script>
