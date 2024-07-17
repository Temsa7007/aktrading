<template>
  <svg class="pattern-lock" viewBox="0 0 120 120" @mouseup="stopDrawing" @mouseleave="stopDrawing"
       @touchend="stopDrawing" @touchcancel="stopDrawing">
    <!-- Lines -->
    <line v-for="(line, index) in lines" :key="`line-${index}`" 
          :x1="line.x1" :y1="line.y1" :x2="line.x2" :y2="line.y2"
          stroke="darkgrey" stroke-width="2" />
    <!-- Dots -->
    <circle v-for="(dot, index) in dots" :key="`dot-${index}`" 
            :cx="dot.x" :cy="dot.y" r="6" class="dot"
            :class="{ 'dot-active': activeDots.includes(index + 1), 'dot-hover': hoveredDot === index + 1 }"
            @mousedown.prevent="startDrawing(index + 1)"
            @touchstart.prevent="startDrawing(index + 1)"
            @touchmove.prevent="trackTouch(index + 1)" fill="#ccc" />
  </svg>
</template>

<script>

export default {
  data() {
    return {
      dots: [
        { x: 20, y: 20 }, { x: 60, y: 20 }, { x: 100, y: 20 },
        { x: 20, y: 60 }, { x: 60, y: 60 }, { x: 100, y: 60 },
        { x: 20, y: 100 }, { x: 60, y: 100 }, { x: 100, y: 100 }
      ],
      activeDots: [],
      lines: [],
      isDrawing: false,
      hoveredDot: null,
    };
  },
  methods: {
    startDrawing(dotIndex) {
      if (!this.activeDots.includes(dotIndex)) {
        this.activeDots.push(dotIndex);
        this.isDrawing = true;
      }
    },
    trackTouch(dotIndex) {
      if (!this.activeDots.includes(dotIndex)) {
        this.addToPattern(dotIndex);
      }
    },
    addToPattern(dotIndex) {
      if (this.isDrawing && !this.activeDots.includes(dotIndex)) {
        const lastDotIndex = this.activeDots[this.activeDots.length - 1];
        const lastDot = this.dots[lastDotIndex - 1];
        const newDot = this.dots[dotIndex - 1];
        this.lines.push({
          x1: lastDot.x,
          y1: lastDot.y,
          x2: newDot.x,
          y2: newDot.y,
        });
        this.activeDots.push(dotIndex);
      }
    },
    stopDrawing() {
      this.isDrawing = false;
      if (this.activeDots.length > 1) { 
        this.$emit('pattern-complete', this.activeDots.join('-'));
      }
      this.activeDots = [];
      this.lines = [];
    }
  }
};
</script>

<style scoped>
.pattern-lock {
  width: 100%;
  height: auto;
  background-color: #f5f5f5;
  border: 2px solid #ccc;
  border-radius: 8px;
  overflow: hidden;
  cursor: pointer;
}

.dot {
  fill: #ccc;
  transition: fill 0.2s ease-in-out;
}

.dot-hover {
  fill: orange;
}

.dot-active {
  stroke: orange;
  stroke-width: 2px;
}
</style>
