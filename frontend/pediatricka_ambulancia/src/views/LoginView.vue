<template>
  <div>
    <h2>Login</h2>
    <form @submit.prevent="login">
      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="loginData.email" required>
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="loginData.password" required>
      </div>
      <button type="submit">Login</button>
    </form>
    <button @click="logout">Logout</button>
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
      axios.post('http://localhost:8080/api/login', this.loginData)
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
      axios.post('http://localhost:8080/api/logout', {}, { headers: { Authorization: `Bearer ${localStorage.getItem('userToken')}` } })
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
<style>

</style>