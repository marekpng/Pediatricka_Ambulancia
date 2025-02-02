<template>
    <div v-if="isLoading" class="loading-overlay">
      <div class="loading-animation">
        <img src="@/assets/medical-loader.gif" alt="Loading..." />
        <p class="loading-text">Načítavam, prosím počkajte...</p>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "LoadingOverlay",
    props: {
      isLoading: Boolean,
    },
  };
  </script>
  
  <style scoped>
  .loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
  }
  
  .loading-animation {
    text-align: center;
  }
  
  .loading-animation img {
    width: 150px;
    height: 150px;
    animation: rotate 3.5s linear infinite;
  }

  
  .loading-text {
    font-size: 1.2rem;
    color: #007bff;
    margin-top: 10px;
    font-weight: bold;
  }
  </style>
  