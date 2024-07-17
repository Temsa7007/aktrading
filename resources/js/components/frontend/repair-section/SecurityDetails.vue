<template>
  <div class="step-content max-w-lg mx-auto p-5 bg-white rounded-lg text-center">
    <h2 class="section-title text-2xl text-gray-800 mb-2">Formulaire de réparation</h2>
    <p class="description text-sm text-gray-600 mb-4">Veuillez fournir vos informations de sécurité pour l'appareil.</p>

    <div class="question mb-6">
      <label for="securityType" class="field-label text-lg text-gray-600 mb-2">Utilisez-vous un code PIN ou un modèle?</label>
      <select id="securityType" v-model="securityType" class="input-field w-full py-2 px-3 border border-gray-300 rounded-lg text-gray-800 leading-tight focus:outline-none focus:ring focus:border-blue-300" required>
        <option disabled value="">Sélectionner</option>
        <option value="pin">Code PIN</option>
        <option value="pattern">Modèle</option>
      </select>
    </div>

    <div v-if="securityType === 'pin'" class="question mb-6">
      <label for="pinCode" class="field-label text-lg text-gray-600 mb-2">Veuillez entrer votre code PIN</label>
      <input type="text" id="pinCode" v-model="pinCode" class="input-field w-full py-2 px-3 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring focus:border-red-300" required @blur="emitPinData">
    </div>

    <div v-if="securityType === 'pattern'" class="question mb-6">
      <label for="patternInput" class="field-label text-lg text-gray-600 mb-2">Entrez votre modèle</label>
      <div class="flex items-center">
        <button @click="showPatternDialog = true" class="text-orange-600 text-lg pl-2 cursor-pointer hover:text-red-500 transition duration-300">
          <i class="fa-solid fa-circle-info"></i> Dessiner le modèle
        </button>
      </div>
    </div>

    <!-- Pattern Dialog -->
    <div v-if="showPatternDialog" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-4 rounded-lg relative pattern-lock">
        <div>
          <div class="container">
            <div
              class="circle-grid"
              @mousedown="handleMouseDown"
              @mousemove="handleMouseMove"
              @mouseup="handleMouseUp"
              @touchstart="handleTouchStart"
              @touchmove="handleTouchMove"
              @touchend="handleTouchEnd"
            >
              <div
                class="circle"
                v-for="(value, index) in circleValues"
                :key="index"
                :data-value="value"
                :class="{ active: isActiveCircle(value) }"
              >
                <span class="circle-text">{{ value }}</span>
              </div>
              <canvas ref="canvas" class="canvas"></canvas>
            </div>
            <div class="buttons">
              <button @click="resetPattern" class="py-2 px-4 rounded bg-orange-600 text-white cursor-pointer disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed hover:bg-orange-700 transition duration-300">Reset</button>
              <button @click="donePattern" class="py-2 px-4 rounded bg-orange-600 text-white cursor-pointer disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed hover:bg-orange-700 transition duration-300">Done</button>
            </div>
          </div>
          <div>
            <p>{{ patternNumbers.join(' ') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, defineEmits, onMounted, watch } from 'vue';

const securityType = ref('');
const pinCode = ref('');
const showPatternDialog = ref(false);
const patternNumbers = ref([]);
const circleValues = ref([1, 2, 3, 4, 5, 6, 7, 8, 9]);
const touching = ref(false);
const mouseDown = ref(false);

const emit = defineEmits(['updateData']);

const emitPinData = () => {
  if (securityType.value === 'pin' && pinCode.value) {
    emit('updateData', { securityType: 'pin', pinCode: pinCode.value });
  }
};

const donePattern = () => {
  if (securityType.value === 'pattern' && patternNumbers.value.length) {
    emit('updateData', { securityType: 'pattern', pattern: patternNumbers.value });
  }
  showPatternDialog.value = false;
};

const closePatternDialog = () => {
  showPatternDialog.value = false;
};


const handleOverflow = (showDialog) => {
  document.body.style.overflow = showDialog ? 'hidden' : '';
};

watch(showPatternDialog, handleOverflow);



const handleTouchStart = (event) => {
  touching.value = true;
  handleTouchMove(event);
};

const handleTouchMove = (event) => {
  if (!touching.value) return;
  const touch = event.touches[0];
  const element = document.elementFromPoint(touch.clientX, touch.clientY);
  if (element && element.classList.contains('circle')) {
    const value = parseInt(element.dataset.value, 10);
    handleCircleClick(value);
  }
};

const handleTouchEnd = () => {
  touching.value = false;
};

const handleMouseDown = (event) => {
  mouseDown.value = true;
  handleMouseMove(event);
};

const handleMouseMove = (event) => {
  if (!mouseDown.value) return;
  const element = document.elementFromPoint(event.clientX, event.clientY);
  if (element && element.classList.contains('circle')) {
    const value = parseInt(element.dataset.value, 10);
    handleCircleClick(value);
  }
};

const handleMouseUp = () => {
  mouseDown.value = false;
};

const handleCircleClick = (value) => {
  if (!patternNumbers.value.includes(value)) {
    patternNumbers.value.push(value);
    drawLine();
  }
};

const resetPattern = () => {
  patternNumbers.value = [];
  clearCanvas();
};

const isActiveCircle = (value) => {
  return patternNumbers.value.includes(value);
};

const initializeCanvas = () => {
  const canvas = document.querySelector('.canvas');
  const ctx = canvas.getContext('2d');
  canvas.width = canvas.clientWidth;
  canvas.height = canvas.clientHeight;
  ctx.lineWidth = 0;
  ctx.strokeStyle = 'transparent';
};

const clearCanvas = () => {
  const canvas = document.querySelector('.canvas');
  const ctx = canvas.getContext('2d');
  ctx.clearRect(0, 0, canvas.width, canvas.height);
};

const drawLine = () => {
  const canvas = document.querySelector('.canvas');
  const ctx = canvas.getContext('2d');
  clearCanvas();

  if (patternNumbers.value.length < 2) return;

  ctx.beginPath();
  ctx.strokeStyle = 'transparent'; 
  patternNumbers.value.forEach((num, index) => {
    const element = document.querySelector(`.circle[data-value="${num}"]`);
    const rect = element.getBoundingClientRect();
    const x = rect.left + rect.width / 2 - canvas.getBoundingClientRect().left;
    const y = rect.top + rect.height / 2 - canvas.getBoundingClientRect().top;
    if (index === 0) {
      ctx.moveTo(x, y);
    } else {
      ctx.lineTo(x, y);
    }
  });
  ctx.stroke();
};

onMounted(() => {
  initializeCanvas();
});


</script>

<style scoped>
.circle-grid {
  display: grid;
  grid-template-columns: repeat(3, 100px);
  grid-gap: 20px;
  position: relative;
 
  height: 360px;
  justify-items: center;
  margin-top: 30px;
}

.circle {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 70px;
  height: 70px;
  border-radius: 50%;
  background-color: #e4e4e4;
  color: white;
  font-size: 24px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  user-select: none;
}

.circle-text {
  pointer-events: none;
}

.circle.active {
  background-color: #cc602e;
}

.canvas {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  z-index: 0;
}

.buttons {
  display: flex;
  justify-content: space-between;
  margin-top: 10px;
}

.buttons button {
  padding: 5px 10px;
  background-color: #cc602e;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.buttons button:hover {
  background-color: #b24d1a;
}


</style>
