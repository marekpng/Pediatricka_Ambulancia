<template>
  <div class="login-container">
    <h2>Admin Login</h2>
    <form @submit.prevent="login" class="login-form">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="loginData.email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="loginData.password" required>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
 
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Login',
  data() {
    return {
      loginData: {
        email: '',
        password: ''
      }
    };
  },
  methods: {
    login() {
      axios.post('http://localhost/identify-service/api/login', this.loginData)
          .then(response => {
            console.log('Login successful:', response.data);
            const token = response.data.token;
            localStorage.setItem('userToken', token);
            window.location.href = '/admin';
          })
          .catch(error => {
            console.error('Error logging in:', error.response.data);
          });
    },
    logout() {
      axios.post('http://localhost/identify-service/api/logout', {}, {
        headers: { Authorization: `Bearer ${localStorage.getItem('userToken')}` }
      })
          .then(response => {
            console.log(response.data);
            localStorage.removeItem('userToken');
            window.location.href = '/';
          })
          .catch(error => {
            console.error('Error logging out:', error);
          });
    }
  }
}
</script>

<style scoped>
* {
  box-sizing: border-box;
}
body {
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f4f7f8;
}

.login-container {
  max-width: 400px;
  margin: 50px auto;
  padding: 30px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.login-container h2 {
  text-align: center;
  margin-bottom: 25px;
  color: #333;
}

.form-group {
  margin-bottom: 20px;
}

.login-container label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
  color: #555;
}

.login-container input {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 16px;
  transition: border-color 0.3s ease;
}

.login-container input:focus {
  outline: none;
  border-color: #007BFF;
}

.btn {
  width: 100%;
  padding: 12px;
  border: none;
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin-top: 10px;
}

.btn-primary {
  background-color: #007BFF;
  color: #fff;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.btn-secondary {
  background-color: #dc3545;
  color: #fff;
}

.btn-secondary:hover {
  background-color: #c82333;
}

@media (max-width: 480px) {
  .login-container {
    margin: 20px;
    padding: 20px;
  }
  .login-container h2 {
    font-size: 1.5rem;
  }
  .btn {
    font-size: 14px;
    padding: 10px;
  }
}
</style>
