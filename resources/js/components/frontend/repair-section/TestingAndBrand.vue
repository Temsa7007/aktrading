<template>
  <div class="step-content max-w-lg mx-auto p-5 bg-white rounded-lg text-center">
    <h2 class="section-title text-2xl text-gray-800 mb-2">Formulaire de réparation</h2>
    <p class="description text-sm text-gray-800 mb-4">Veuillez indiquer la marque de votre téléphone et si vous avez besoin de tests par la suite.</p>

    <!-- Testing requirement selection -->
    <div class="question mb-4">
      <label class="block text-gray-800 mb-2 text-lg">Avez-vous besoin de tests ?</label>
      <select v-model="requireTesting" @change="handleTestingChange" class="custom-select w-full py-2 px-3 border border-gray-300 rounded-lg text-gray-800 leading-tight focus:outline-none focus:ring focus:border-blue-300" required>
        <option disabled value="">Sélectionner</option>
        <option value="Oui">Oui</option>
        <option value="Non">Non</option>
      </select>
      <span v-if="!requireTesting && validationError" class="text-red-600 mt-2">Veuillez sélectionner une option.</span>
      <p v-if="requireTesting === 'Non'" class="text-slate-300 mt-2">*Nous ne testerons pas et nous ne sommes pas responsables sans évaluation.</p>
    </div>

    <!-- Phone state selection -->
    <div class="question mb-4">
      <label for="phoneState" class="block text-gray-800 mb-2 text-lg">Votre téléphone est-il allumé ou éteint ?</label>
      <select id="phoneState" v-model="phoneState" class="custom-select w-full py-2 px-3 border border-gray-300 rounded-lg text-gray-800 leading-tight focus:outline-none focus:ring focus:border-blue-300" required>
        <option disabled value="">Sélectionner</option>
        <option value="On">éteint</option>
        <option value="Off">allumé</option>
      </select>
    </div>

    <!-- Phone brand and model selection -->
    <div class="question flex flex-col sm:flex-row sm:space-x-4 mb-4">
      <div class="flex-1 mb-4 sm:mb-0">
        <label for="phoneBrand" class="block text-gray-800 mb-2 text-lg">Marque de téléphone</label>
        <select id="phoneBrand" v-model="phoneBrand" @change="handleBrandChange" class="custom-select w-full py-2 px-3 border border-gray-300 rounded-lg text-gray-800 leading-tight focus:outline-none focus:ring focus:border-blue-300" required>
          <option disabled value="">Sélectionner</option>
          <option v-for="brand in phoneBrands" :key="brand">{{ brand }}</option>
        </select>
      </div>
      <div class="flex-1">
        <label for="phoneModel" class="block text-gray-800 mb-2 text-lg">Modèle de téléphone</label>
        <input type="text" id="phoneModel" v-model="phoneModel" :disabled="!phoneBrand" @blur="emitData" class="block w-full py-2 px-3 border border-gray-300 rounded-lg text-gray-800 leading-tight focus:outline-none focus:ring focus:border-blue-300" placeholder="Modèle de téléphone" required />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, defineEmits, watchEffect, watch } from 'vue';

const requireTesting = ref('');
const phoneState = ref('');
const phoneBrand = ref('');
const phoneModel = ref('');
const phoneBrands = ref([
  'Samsung',
  'Apple',
  'Huawei',
  'Tecno',
  'Infinix',
  'Itel',
  'Redmi',
  'Oppo',
  'Realmi',
  'Nokia',
  'Motorola',
  'TCL',
  'LG',
  'Google'
]);

const validationError = ref(false);
const emit = defineEmits(['updateData', 'skipSecurity', 'resetSkipSecurity']);

watchEffect(() => {
  if (requireTesting.value && phoneState.value && phoneBrand.value && phoneModel.value) {
    emit('updateData', {
      requireTesting: requireTesting.value,
      phoneState: phoneState.value,
      phoneBrand: phoneBrand.value,
      phoneModel: phoneModel.value
    });
    if (requireTesting.value === 'Non') {
      emit('skipSecurity');
    } else {
      emit('resetSkipSecurity');
    }
  }
});

const handleTestingChange = () => {
  validationError.value = false;
  if (requireTesting.value === 'Non') {
    emit('skipSecurity');
  } else {
    emit('resetSkipSecurity');
  }
};

const handleBrandChange = () => {
  emitData();
};

const emitData = () => {
  if (phoneBrand.value && phoneModel.value) {
    emit('updateData', {
      phoneBrand: phoneBrand.value,
      phoneModel: phoneModel.value
    });
  }
};
</script>

<style scoped>
/* No radio button styles needed */
</style>
