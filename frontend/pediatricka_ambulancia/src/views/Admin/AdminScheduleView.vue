<template>
    <div class="container py-5">
      <h1>Manage Schedule</h1>


    <section class="mb-5">
      <h2>Manage Schedules</h2>
      <button class="btn btn-primary" @click="goToManageSchedule">
        Manage Existing Schedules
      </button>
    </section>
  
      <section class="mb-5">
        <h2>Current Schedule</h2>
        <div v-if="schedule.working_hours && schedule.days_off">
          <div class="mb-4">
            <h4>Working Hours</h4>
            <p>Start Time: {{ schedule.working_hours.start_time }}</p>
            <p>End Time: {{ schedule.working_hours.end_time }}</p>
            <p>Slot Duration: {{ schedule.working_hours.slot_duration }} minutes</p>
            <p>Days: {{ schedule.working_hours.days.join(', ') }}</p>
          </div>
          <div class="mb-4">
            <h4>Days Off</h4>
            <ul>
              <li v-for="dayOff in schedule.days_off" :key="dayOff.id">
                {{ dayOff.date }} ({{ dayOff.reason || 'No reason provided' }})
                <button
                  class="btn btn-danger btn-sm"
                  @click="deleteDayOff(dayOff.id)"
                >
                  Delete
                </button>
              </li>
            </ul>
          </div>
        </div>
        <div v-else>
          <p>No working hours or days off set.</p>
        </div>
      </section>
  
      <section class="mb-5">
        <h2>Set Working Hours</h2>
        <form @submit.prevent="setWorkingHours">
          <div class="row g-3">
            <div class="col-md-3">
              <label for="start-time" class="form-label">Start Time</label>
              <input
                type="time"
                id="start-time"
                class="form-control"
                v-model="workingHours.start_time"
                required
              />
            </div>
            <div class="col-md-3">
              <label for="end-time" class="form-label">End Time</label>
              <input
                type="time"
                id="end-time"
                class="form-control"
                v-model="workingHours.end_time"
                required
              />
            </div>
            <div class="col-md-3">
              <label for="slot-duration" class="form-label">Slot Duration (Minutes)</label>
              <input
                type="number"
                id="slot-duration"
                class="form-control"
                v-model="workingHours.slot_duration"
                min="5"
                max="120"
                required
              />
            </div>
            <div class="col-md-3">
              <label for="working-days" class="form-label">Days</label>
              <select
                id="working-days"
                class="form-control"
                v-model="workingHours.days"
                multiple
              >
                <option v-for="day in weekDays" :value="day" :key="day">
                  {{ day }}
                </option>
              </select>
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3">Set Working Hours</button>
        </form>
      </section>
  
      <section class="mb-5">
        <h2>Add Day Off</h2>
        <form @submit.prevent="addDayOff">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="day-off-date" class="form-label">Date</label>
              <input
                type="date"
                id="day-off-date"
                class="form-control"
                v-model="newDayOff.date"
                required
              />
            </div>
            <div class="col-md-6">
              <label for="day-off-reason" class="form-label">Reason</label>
              <input
                type="text"
                id="day-off-reason"
                class="form-control"
                v-model="newDayOff.reason"
                placeholder="Optional"
              />
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3">Add Day Off</button>
        </form>
      </section>
  
      <section>
        <h2>Generate Timeslots</h2>
        <form @submit.prevent="generateTimeslots">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="timeslot-start-date" class="form-label">Start Date</label>
              <input
                type="date"
                id="timeslot-start-date"
                class="form-control"
                v-model="timeslotRange.start_date"
                required
              />
            </div>
            <div class="col-md-6">
              <label for="timeslot-end-date" class="form-label">End Date</label>
              <input
                type="date"
                id="timeslot-end-date"
                class="form-control"
                v-model="timeslotRange.end_date"
                required
              />
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3">Generate Timeslots</button>
        </form>
      </section>
    </div>
  </template>

<script>
import axios from "axios";
import { inject } from "vue";

export default {
  data() {
    return {
      schedule: {
        working_hours: null,
        days_off: [],
      },
      workingHours: {
        start_time: "",
        end_time: "",
        slot_duration: 30,
        days: [],
      },
      newDayOff: {
        date: "",
        reason: "",
      },
      timeslotRange: {
        start_date: "",
        end_date: "",
      },
      weekDays: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
      setLoading: null,
    };
  },
  created() {
    this.setLoading = inject("setLoading"); 
  },
  methods: {
    async fetchSchedule() {
      if (this.setLoading) this.setLoading(true);
      try {
        const response = await axios.get("http://localhost/reservation-service/api/schedule");
        this.schedule = response.data;
      } catch (error) {
        console.error("Error fetching schedule:", error.response?.data || error);
      } finally {
        if (this.setLoading) this.setLoading(false);
      }
    },

    async setWorkingHours() {
      if (this.setLoading) this.setLoading(true);
      try {
        await axios.post("http://localhost/reservation-service/api/schedule/working-hours", this.workingHours, {
          headers: { Authorization: `Bearer ${localStorage.getItem("userToken")}` },
        });
        await this.fetchSchedule();
      } catch (error) {
        console.error("Error setting working hours:", error.response?.data || error);
      } finally {
        if (this.setLoading) this.setLoading(false);
      }
    },

    async addDayOff() {
      if (this.setLoading) this.setLoading(true);
      try {
        await axios.post("http://localhost/reservation-service/api/schedule/days-off", this.newDayOff, {
          headers: { Authorization: `Bearer ${localStorage.getItem("userToken")}` },
        });
        await this.fetchSchedule();
      } catch (error) {
        console.error("Error adding day off:", error.response?.data || error);
      } finally {
        if (this.setLoading) this.setLoading(false);
      }
    },

    async deleteDayOff(id) {
      if (this.setLoading) this.setLoading(true);
      try {
        await axios.delete(`http://localhost/reservation-service/api/schedule/days-off/${id}`, {
          headers: { Authorization: `Bearer ${localStorage.getItem("userToken")}` },
        });
        await this.fetchSchedule();
      } catch (error) {
        console.error("Error deleting day off:", error.response?.data || error);
      } finally {
        if (this.setLoading) this.setLoading(false);
      }
    },

    async generateTimeslots() {
      if (this.setLoading) this.setLoading(true);
      try {
        await axios.post("http://localhost/reservation-service/api/schedule/generate-timeslots", this.timeslotRange, {
          headers: { Authorization: `Bearer ${localStorage.getItem("userToken")}` },
        });
        await this.fetchSchedule();
      } catch (error) {
        console.error("Error generating timeslots:", error.response?.data || error);
      } finally {
        if (this.setLoading) this.setLoading(false);
      }
    },

    goToManageSchedule() {
      this.$router.push("/admin/schedule/manage");
    },
  },
  async mounted() {
    await this.fetchSchedule();
  },
};
</script>

  <style scoped>
  </style>
  