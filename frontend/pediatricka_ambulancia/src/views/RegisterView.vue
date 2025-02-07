<template>
  <div class="register-container">
    <div class="register-box">
      <h2 class="register-title">Register New User</h2>
      <form @submit.prevent="registerAdmin" class="register-form">
        
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" id="name" v-model="formData.name" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="formData.email" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="formData.password" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="password_confirmation">Confirm Password:</label>
          <input type="password" id="password_confirmation" v-model="formData.password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary" :disabled="loading">
          <span v-if="loading">Registering...</span>
          <span v-else>Register</span>
        </button>

        <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { inject } from "vue";

export default {
  name: "RegisterView",
  data() {
    return {
      formData: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      errorMessage: "",
      loading: false,
      setLoading: null,
    };
  },
  created() {
    this.setLoading = inject("setLoading"); 
  },
  methods: {
    async registerAdmin() {
      this.loading = true;
      if (this.setLoading) this.setLoading(true);

      try {
        const response = await axios.post("http://localhost/identify-service/api/register", this.formData);
        console.log("Admin registered successfully:", response.data);
        await router.push({ name: "home" });
      } catch (error) {
        this.errorMessage = error.response?.data?.message || "Registration failed. Please try again.";
      } finally {
        this.loading = false;
        if (this.setLoading) this.setLoading(false);
      }
    },
  },
};
</script>

<style scoped>
.register-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f8f9fa;
  padding: 20px;
}

.register-box {
  width: 100%;
  max-width: 400px;
  padding: 2rem;
  background: white;
  border-radius: 10px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.register-title {
  font-size: 24px;
  margin-bottom: 1rem;
  color: #333;
}

.register-form {
  display: flex;
  flex-direction: column;
}

.form-group {
  margin-bottom: 15px;
  text-align: left;
}

.form-group label {
  display: block;
  font-weight: 600;
  margin-bottom: 5px;
  color: #555;
}

.form-control {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  transition: border-color 0.3s ease-in-out;
}

.form-control:focus {
  border-color: #007bff;
  outline: none;
}

.btn {
  padding: 10px;
  font-size: 16px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.3s ease-in-out;
}

.btn-primary {
  background-color: #007bff;
  color: white;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.error-message {
  margin-top: 10px;
  color: red;
  font-size: 14px;
}

@media (max-width: 480px) {
  .register-box {
    width: 100%;
    padding: 1.5rem;
  }

  .btn {
    font-size: 14px;
  }
}
</style>
