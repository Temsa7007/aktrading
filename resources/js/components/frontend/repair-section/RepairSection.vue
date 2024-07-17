<template>
  <div class="flex flex-col items-center justify-between max-w-lg mx-auto p-5 bg-white shadow-md rounded-lg  sm:my-12" style="min-height: 644px; margin-bottom: 150px;">
      <div class="w-full">
          <div class="w-full bg-gray-300 rounded-full h-2.5 my-5">
              <div class="bg-orange-600 h-2.5 rounded-full" :style="{ width: progressBarWidth }"></div>
          </div>
          <div class="text-lg font-semibold text-center">Étape {{ currentStep }} de 5</div>
      </div>

      <form @submit.prevent="handleFormSubmit" class="w-full mt-5">
          <!-- Each component now emits 'updateData' with its specific data -->
          <div class="w-full flex flex-col items-center flex-grow">
          <transition name="fade" mode="out-in">
              <component :is="currentComponent" @updateData="handleUpdate" @skipSecurity="handleSkipSecurity" @resetSkipSecurity="handleResetSkipSecurity" key="currentComponent" />
          </transition>
      </div>
          <div class="flex justify-between w-full mt-5">
              <button type="button" @click="goBack" :disabled="currentStep === 1"
                      class="py-2 px-4 rounded bg-orange-600 text-white cursor-pointer disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed hover:bg-orange-700 transition duration-300">Retourner</button>
              <button type="submit"
                      class="py-2 px-4 rounded bg-orange-600 text-white cursor-pointer hover:bg-orange-700 transition duration-300">{{ currentStep < 5 ? 'Continuer' : 'Soumettre' }}</button>
          </div>
      </form>
  </div>
</template>

<script>
import { ref, computed, nextTick } from 'vue';
import ServiceSelection from './ServiceSelection.vue';
import TestingAndBrand from './TestingAndBrand.vue';
import SecurityDetails from './SecurityDetails.vue';
import UserDetails from './UserDetails.vue';
import ConfirmationStep from './ConfirmationStep.vue';

export default {
  components: {
    ServiceSelection,
    TestingAndBrand,
    SecurityDetails,
    UserDetails,
    ConfirmationStep
  },
  data() {
    return {
      currentStep: 1,
      components: [ServiceSelection, TestingAndBrand, SecurityDetails, UserDetails, ConfirmationStep],
      collectedData: {}, // Object to store data from each step
      skipSecurity: false, // Flag to determine whether to skip SecurityDetails
      isFormValid: false, // Validation flag
      validationError: false // Validation error flag for the current step
    };
  },
  computed: {
    currentComponent() {
      return this.components[this.currentStep - 1];
    },
    progressBarWidth() {
      return `${(this.currentStep / 5) * 100}%`;
    }
  },
  methods: {
    handleFormSubmit() {
  if (this.validateCurrentStep()) {
    nextTick(() => {
      if (this.currentStep < 5) {
        if (this.skipSecurity && this.currentStep === 2) {
          this.currentStep += 2; // Correctly skip the SecurityDetails step
        } else {
          this.currentStep++;
        }
        this.scrollToTop();
      } else {
        this.submitAllData();
      }
    });
  } else {
    this.validationError = true;
  }
},
    goBack() {
      nextTick(() => {
        if (this.currentStep > 1) {
          this.currentStep--;
          this.scrollToTop();
        }
      });
    },
    handleUpdate(data) {
      // Checks if there's already data collected for the current step; if so, merge it
      if (this.collectedData[`step${this.currentStep}`]) {
        this.collectedData[`step${this.currentStep}`] = {
          ...this.collectedData[`step${this.currentStep}`],
          ...data
        };
      } else {
        // If no data exists yet for this step, simply set it
        this.collectedData[`step${this.currentStep}`] = data;
      }
      this.validationError = false; // Reset validation error when data is updated
    },
    handleSkipSecurity() {
      this.skipSecurity = true;
    },
    handleResetSkipSecurity() {
      this.skipSecurity = false;
    },
    scrollToTop() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    },
    validateCurrentStep() {
      const data = this.collectedData[`step${this.currentStep}`];
      if (!data) return false;

      switch (this.currentStep) {
        case 1: // ServiceSelection
          return !!data.service;
        case 2: // TestingAndBrand
          return !!data.requireTesting && !!data.phoneState && !!data.phoneBrand && !!data.phoneModel;
        case 3: // SecurityDetails (if not skipped)
          return this.skipSecurity || (!!data.securityType && (data.securityType === 'pin' ? !!data.pinCode : !!data.pattern));
        case 4: // UserDetails
          return !!data.fullName && !!data.phoneNumber;
        case 5: // ConfirmationStep
          return !!data.acceptedTerms;
        default:
          return false;
      }
    },
    submitAllData() {
      // Prepare and send all collected data
      let message = "Order Details:\n";
      Object.keys(this.collectedData).forEach(step => {
        message += `${step}:\n`;
        Object.entries(this.collectedData[step]).forEach(([key, value]) => {
          message += `${key}: ${value}\n`;
        });
        message += "\n"; // Adds spacing between steps for clarity
      });

      const encodedMessage = encodeURIComponent(message);
      const phoneNumber = '+22507691089';
      const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
      const baseUrl = isMobile ? `whatsapp://send` : `https://web.whatsapp.com/send`;
      const whatsappUrl = `${baseUrl}?phone=${phoneNumber}&text=${encodedMessage}`;
      window.open(whatsappUrl, '_blank');
    }
  }
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
html {
  scroll-behavior: smooth;

  overflow: hidden;
  overscroll-behavior: none;
}
</style>
