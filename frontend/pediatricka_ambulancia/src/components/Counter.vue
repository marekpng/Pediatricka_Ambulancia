<template>
  <div class="counter-container border-start border-light ps-4">
    <h2 class="text-white mb-1">{{ animatedNumber }}+ </h2>
    <p class="text-light mb-0">{{ label }}</p>
  </div>
</template>
<script>
export default {
  props: {
    finalNumber: {
      type: Number,
      required: true
    },
    label: {
      type: String,
      default: 'Value'
    }
  },
  data() {
    return {
      animatedNumber: 0,
    };
  },
  mounted() {
    this.animateNumber();
  },
  methods: {
    animateNumber() {
      const duration = 2000;
      const steps = 100;
      const stepTime = duration / steps;
      let currentStep = 0;

      const interval = setInterval(() => {
        currentStep++;
        this.animatedNumber = Math.floor((currentStep / steps) * this.finalNumber);

        if (currentStep === steps) {
          clearInterval(interval);
        }
      }, stepTime);
    },
  },
};
</script>

<style scoped>

</style>