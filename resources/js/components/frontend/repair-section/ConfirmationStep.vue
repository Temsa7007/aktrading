<template>
  <div class="step-content max-w-lg mx-auto p-5 bg-white rounded-lg text-center">
    <img src="./Bag.png" alt="bag" class="max-w-xs mx-auto p-3">
    <h2 class="section-title text-2xl text-gray-800 mb-2">Demande Reçue</h2>

    <div class="order-received mb-5">
      <p class="confirmation-message text-sm text-gray-800 mb-5">Veuillez soumettre votre billet sur notre WhatsApp afin que nous puissions mieux vous servir!</p>
      <label for="terms" class="checkbox-label inline-block text-gray-800 text-base mb-2">
        <input type="checkbox" id="terms" v-model="acceptedTerms" @change="emitAcceptedTerms" required class="mr-2 align-middle" />
        Accepte le <a href="/terms-of-use" class="link text-orange-600 underline">Conditions D'utilisation</a> of AK Trading
      </label>
    </div>

  
  </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue';

const acceptedTerms = ref(false);
const notes = ref('');
const emit = defineEmits(['updateData', 'validationFailed']);

function emitAcceptedTerms() {
  if (acceptedTerms.value) {
    emit('updateData', { acceptedTerms: acceptedTerms.value });
  } else {
    emit('validationFailed', 'Vous devez accepter les conditions pour continuer.');
  }
}


</script>

<style scoped>
/* No custom CSS needed if using Tailwind */
</style>
