<template>
  <transition name="overlay">
    <div class="overlay" v-show="openedOverlay"></div>
  </transition>
</template>

<script>
export default {
  props: ["openedOverlay"]
};
</script>

<style lang="scss">
.overlay {
  position: fixed;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  background: rgba(15, 34, 43, 0.8);
  z-index: 10;
}

.overlay-enter-active,
.overlay-leave-active {
  transition: 0.6s;
}

.overlay-enter,
.overlay-leave-to {
  opacity: 0;
}
</style>