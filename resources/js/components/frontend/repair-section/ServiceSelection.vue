<template>
  
  <div class="service-selection-container max-w-lg mx-auto p-5 bg-white rounded-lg text-center">
      <img src="./gear.png" alt="gear" class="max-w-xl mx-auto p-3 mb-50 size-55">
    <h2 class="section-title text-2xl text-gray-800 mb-2">Formulaire de réparation</h2>
    <p class="description text-sm text-gray-800 mb-4">Réparons votre appareil dès que possible! Sélectionnez le service dont vous avez besoin.</p>
    <label for="service" class="block text-lg text-gray-800 mb-2">De quel service avez-vous besoin?</label>
    <select id="service" v-model="selectedService" @change="handleServiceChange" required class="block w-full py-2 px-3 border border-gray-300 rounded-lg text-gray-800 leading-tight focus:outline-none focus:ring focus:border-blue-300">
      <option disabled value="">Sélectionner</option>
      <option v-for="service in services" :key="service">{{ service }}</option>
    </select>
    <div v-if="selectedService === 'Autre Service'" class="mt-4">
      <label for="otherService" class="block text-lg text-gray-800 mb-2">Veuillez spécifier le service</label>
      <input type="text" id="otherService" v-model="otherService" @blur="emitOtherServiceData" required class="block w-full py-2 px-3 border border-gray-300 rounded-lg text-gray-800 leading-tight focus:outline-none focus:ring focus:border-blue-300" placeholder="Spécifier le service" />
    </div>
  </div>
</template>

<script setup>
import { ref, watchEffect, defineEmits } from 'vue';

// Service selection data
const selectedService = ref('');
const otherService = ref('');
const services = [
  'Remplacement d\'écran',
  'Réparation sur plaquette',
  'Programmation',
  'Autre Service'
];

// Define the event emitter
const emit = defineEmits(['updateData']);

const handleServiceChange = () => {
  if (selectedService.value !== 'Autre Service') {
    emit('updateData', { service: selectedService.value });
  }
};

const emitOtherServiceData = () => {
  if (selectedService.value === 'Autre Service' && otherService.value) {
    emit('updateData', { service: otherService.value });
  }
};

watchEffect(() => {
  if (selectedService.value && selectedService.value !== 'Autre Service') {
    emit('updateData', { service: selectedService.value });
  }
});
</script>

<style scoped>
/* No custom CSS needed if using Tailwind */
</style>
