<template>
  <div>
    <h2>Register New User</h2>
    <form @submit.prevent="registerAdmin">
      <div>
        <label for="name">Name:</label>
        <input type="text" id="name" v-model="formData.name" required>
      </div>
      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="formData.email" required>
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="formData.password" required>
      </div>
      <div>
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" id="password_confirmation" v-model="formData.password_confirmation" required>
      </div>
      <button type="submit">Register</button>
    </form>
    <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
  </div>
</template>

<script>
import axios from "axios";
// import router from "@/router/index.js";
export default {
  name: "RegisterView",
  data() {
    return {
      formData: {
        name: "",
        email: "",
        password: "",
        password_confirmation: ""
      },
      errorMessage: ""
    };
  },
  methods: {
    async registerAdmin() {
      try {
        const response = await axios.post("http://127.0.0.1:8000/api/register", this.formData);
        // Handle successful registration
        console.log("Admin registered successfully:", response.data);
        await router.push({name: 'home'});
      } catch (error) {
        // Handle registration error
        this.errorMessage = error.response.data.message;

      }
    }
  }
};
</script>

<style scoped>
.error {
  color: red;
}
</style>
