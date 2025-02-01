   <template>
    <div class="admin-dashboard">
      <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
      </div>
      <div class="dashboard-buttons">
        <button class="btn btn-primary" @click="navigateTo('admin/appointments')">Appointments</button>
        <button class="btn btn-secondary" @click="navigateTo('admin/schedule')">Schedule</button>
        <button class="btn btn-danger" @click="logout">Logout</button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "AdminDashboard",
    methods: {
      navigateTo(route) {
        this.$router.push(`/${route}`);
      },
      logout() {
        localStorage.removeItem("userToken");
        window.location.href = "/login";
      },
    },
    mounted() {
      const token = localStorage.getItem("userToken");
      if (!token) {
        window.location.href = "/login";
      }
    },
  };
  </script>
  
  <style scoped>
  .admin-dashboard {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 2rem;
    background-color: #f4f7f8;
  }
  
  .dashboard-header {
    text-align: center;
    margin-bottom: 2rem;
  }
  
  .dashboard-header h1 {
    font-size: 2.5rem;
    color: #333;
    margin: 0;
  }
  
  .dashboard-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    justify-content: center;
  }
  
  .btn {
    min-width: 150px;
    padding: 15px 25px;
    font-size: 1rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
  }
  
  .btn:hover {
    transform: translateY(-2px);
  }
  
  .btn-primary {
    background-color: #007BFF;
    color: #fff;
  }
  .btn-primary:hover {
    background-color: #0056b3;
  }
  
  .btn-secondary {
    background-color: #6c757d;
    color: #fff;
  }
  .btn-secondary:hover {
    background-color: #5a6268;
  }
  
  .btn-danger {
    background-color: #dc3545;
    color: #fff;
  }
  .btn-danger:hover {
    background-color: #c82333;
  }
  
  @media (max-width: 600px) {
    .dashboard-header h1 {
      font-size: 2rem;
    }
    .btn {
      min-width: 120px;
      padding: 12px 20px;
      font-size: 0.9rem;
    }
  }
  </style>
  