<template>
  <div v-if="container" class="button-container">
    <button
      class="btn button-common waves-effect waves-light"
      v-on="$listeners"
      :disabled="disabled"
    >
      <slot></slot>
    </button>
  </div>
  <button
    class="btn button-common waves-effect waves-light"
    v-else
    v-on="$listeners"
    :disabled="disabled"
  >
    <slot></slot>
  </button>
</template>

<script>
export default {
  props: ["container", "disabled"]
};
</script>

<style lang="scss">
.button-container {
  flex-basis: 100%;
  width: 100%;
}
.button-common {
  display: block;
}
</style>