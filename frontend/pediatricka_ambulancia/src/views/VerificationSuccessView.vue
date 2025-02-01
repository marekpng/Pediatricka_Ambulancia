<template>
    <div class="success-container">
      <h1>🎉 Rezervácia potvrdená!</h1>
      <p>Váš termín bol úspešne verifikovaný.</p>
      <p>V krátkosti dostanete email s informáciami o rezervácií.</p>
      <RouterLink to="/" class="btn btn-primary">Go to Home</RouterLink>
    </div>
  </template>
  
  <script>
  export default {
    name: "VerificationSuccess",
  };
  </script>
  
  <style scoped>
  .success-container {
    text-align: center;
    max-width: 500px;
    margin: 100px auto;
    padding: 20px;
    border-radius: 10px;
    background: #f9f9f9;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }
  h1 {
    color: #28a745;
  }
  p {
    font-size: 18px;
    margin: 10px 0;
  }
  .btn {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    text-decoration: none;
  }
  </style>
  