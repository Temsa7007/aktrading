<template>
  <div class="step-content max-w-lg mx-auto p-5 bg-white rounded-lg text-center">
    <h2 class="section-title text-2xl text-gray-800 mb-2">Formulaire de réparation</h2>
    <p class="description text-sm text-gray-600 mb-5">Veuillez fournir vos coordonnées.</p>

    <div class="input-group mb-5">
      <label for="fullName" class="field-label text-base text-gray-800 mb-1">Nom, Prénom</label>
      <input type="text" id="fullName" v-model="fullName" class="input-field w-full py-2 px-3 border border-gray-300 rounded-lg text-gray-800 leading-tight focus:outline-none focus:ring focus:border-blue-300" placeholder="Your Full Name" @blur="emitData" required />
    </div>
 
    <div class="input-group phone-number-group mb-5">
      <label for="phoneNumber" class="field-label text-base text-gray-800 mb-1">Téléphone</label>
      <div class="phone-number-input w-full">
        <input type="tel" id="phoneNumber" v-model="phoneNumber" class="input-field w-full py-2 px-3 border border-gray-300 rounded-lg text-gray-800 leading-tight focus:outline-none focus:ring focus:border-blue-300" placeholder="00 000 000" @blur="emitData" required />
      </div>
    </div>
    <div class="additional-notes mb-5">
      <label for="notes" class="block text-gray-800 text-lg mb-2">Notes supplémentaires</label>
      <textarea id="notes" v-model="notes" @blur="emitNotes"  class="block w-full py-2 px-3 border border-gray-300 rounded-lg text-gray-800 leading-tight focus:outline-none focus:ring focus:border-blue-300" rows="4" placeholder="Écrivez vos notes ici..." required > </textarea required>
    </div>
  </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue';

const fullName = ref('');
const phoneNumber = ref('');

const emit = defineEmits(['updateData', 'validationFailed']);

const validateName = () => {
  fullName.value = fullName.value.replace(/[^a-zA-Z\s]/g, '');
};

const validatePhone = () => {
  phoneNumber.value = phoneNumber.value.replace(/\D/g, '');
};

const emitData = () => {
  validateName();
  validatePhone();
  if (fullName.value && phoneNumber.value.length >= 7) {
    emit('updateData', { fullName: fullName.value, phoneNumber: phoneNumber.value });
  } else {
    if (!fullName.value) emit('validationFailed', 'Full name is required.');
    if (phoneNumber.value.length < 7) emit('validationFailed', 'Phone number must be at least 7 digits.');
  }
};

function emitNotes() {
  emit('updateData', { notes: notes.value });
}
</script>

<style scoped>
/* No custom CSS needed if using Tailwind */
</style>
