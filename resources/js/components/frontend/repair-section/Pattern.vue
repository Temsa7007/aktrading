<template>
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
            {{ value }}
          </div>
          <canvas ref="canvas" class="canvas"></canvas>
          <button @click="resetPattern">Reset</button>
        </div>
      </div>
      <div>
        <p>{{ patternNumbers.join(' ') }}</p>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'PatternLock',
    data() {
      return {
        circleValues: [1, 2, 3, 4, 5, 6, 7, 8, 9],
        patternNumbers: [],
        touching: false,
        mouseDown: false,
      };
    },
    mounted() {
      this.initializeCanvas();
    },
    methods: {
      handleTouchStart(event) {
        this.touching = true;
        this.handleTouchMove(event);
      },
      handleTouchMove(event) {
        if (!this.touching) return;
        const touch = event.touches[0];
        const element = document.elementFromPoint(touch.clientX, touch.clientY);
        if (element && element.classList.contains('circle')) {
          const value = parseInt(element.dataset.value, 10);
          this.handleCircleClick(value);
        }
      },
      handleTouchEnd() {
        this.touching = false;
      },
      handleMouseDown(event) {
        this.mouseDown = true;
        this.handleMouseMove(event);
      },
      handleMouseMove(event) {
        if (!this.mouseDown) return;
        const element = document.elementFromPoint(event.clientX, event.clientY);
        if (element && element.classList.contains('circle')) {
          const value = parseInt(element.dataset.value, 10);
          this.handleCircleClick(value);
        }
      },
      handleMouseUp() {
        this.mouseDown = false;
      },
      handleCircleClick(value) {
        if (!this.patternNumbers.includes(value)) {
          this.patternNumbers.push(value);
          this.drawLine();
        }
      },
      resetPattern() {
        this.patternNumbers = [];
        this.clearCanvas();
      },
      isActiveCircle(value) {
        return this.patternNumbers.includes(value);
      },
      initializeCanvas() {
        const canvas = this.$refs.canvas;
        const ctx = canvas.getContext('2d');
        canvas.width = canvas.clientWidth;
        canvas.height = canvas.clientHeight;
        ctx.lineWidth = 5;
        ctx.strokeStyle = '#3498db';
      },
      clearCanvas() {
        const canvas = this.$refs.canvas;
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
      },
      drawLine() {
        const canvas = this.$refs.canvas;
        const ctx = canvas.getContext('2d');
        this.clearCanvas();
  
        if (this.patternNumbers.length < 2) return;
  
        ctx.beginPath();
        this.patternNumbers.forEach((num, index) => {
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
      },
    },
  };
  </script>
  
  <style scoped>
  .circle-grid {
    display: grid;
    grid-template-columns: repeat(3, 100px);
    grid-gap: 20px;
    position: relative;
    width: 360px;
  }
  
  .circle {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background-color: #3498db;
    color: white;
    font-size: 24px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .circle.active {
    background-color: #2ecc71;
  }
  
  .canvas {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
  }
  </style>
  