<template>
  <div class="control-panel">
    <transition name="control-panel">
      <div class="control-panel__inner" v-if="show">
        <div class="control-panel__close" @click.stop="closeFunc"></div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  props: ["show", "closeFunc"]
};
</script>

<style lang="scss">
.control-panel {
  perspective: 1000px;
  width: 100%;

  &__inner {
    transform-origin: bottom;
    display: flex;
    justify-content: flex-end;
    height: 30px;
    background: #b39ddb;
    border-bottom: 1px solid white;
  }

  &__close {
    cursor: pointer;
    transition: 0.3s;
    position: relative;
    width: 35px;
    height: 100%;

    &:hover {
      background: #c0392b;
    }

    &:before,
    &:after {
      transition: 0.5s;
      content: "";
      position: absolute;
      width: 18px;
      height: 1px;
      background: #ecf0f1;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%) rotate(45deg);
    }
    &:after {
      transform: translate(-50%, -50%) rotate(-45deg);
    }

    &:hover:before,
    &:hover:after {
      background: white;
    }
  }
}

// АНИМАЦИИ
.control-panel-enter,
.control-panel-leave-to {
  transform: rotateX(90deg);
}

.control-panel-leave-to {
  opacity: 0;
}

.control-panel-enter-active,
.control-panel-leave-active {
  transition: 0.3s 0.3s;
}

.control-panel-leave-active {
  transition: transform 0.3s, opacity 0.01s 0.425s;
}
</style>
