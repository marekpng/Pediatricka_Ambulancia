<template>
    <div class="success-page container py-5">
      <div class="card mx-auto shadow p-4" style="max-width: 600px;">
        <div class="card-body text-center">
          <h1 class="card-title mb-4">Reservation Received</h1>
          <p class="card-text">
            Thank you for booking an appointment! Your reservation is currently pending confirmation.
          </p>
          <p class="card-text">
            Please check your email and click the verification link to confirm your appointment. Your reservation will be complete only after this step.
          </p>
          <p class="card-text text-muted">
            (If you don't see the email, please check your spam folder.)
          </p>
          <RouterLink to="/" class="btn btn-primary mt-4">
            Return Home
          </RouterLink>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "SuccessPage",
  };
  </script>
  
  <style scoped>
  .success-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f9f9f9;
  }
  
  .card {
    border: none;
    border-radius: 15px;
    background: #fff;
  }
  
  @media (max-width: 576px) {
    .card {
      margin: 0 1rem;
    }
  }
  </style>
  