<template>
  <div class="scheme" v-if="isScheme">
    <SchemeItem :schemeObject="scheme"></SchemeItem>
  </div>
</template>

<script>
import SchemeItem from "./scheme-item";
// :data="$store.state.projectDir + '/' + $store.state.projectName + '/' + pdf"

export default {
  components: {
    SchemeItem
  },
  props: ["scheme"],
  computed: {
    isScheme() {
      return !~this.scheme.indexOf("/0.pdf");
    }
  }
};
</script>

<style lang="scss">
.scheme {
  flex-basis: 47%;
  margin-left: 6%;
}
</style>