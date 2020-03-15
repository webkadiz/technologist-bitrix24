<template>
  <div class="scheme" v-if="isScheme">
    <SchemeItem :schemeObject="scheme"></SchemeItem>
  </div>
</template>

<script>
import SchemeItem from "./scheme-item";

export default {
  components: {
    SchemeItem
  },
  props: ["scheme"],
  computed: {
    isScheme() {
      console.log(this.scheme)
      return !~this.scheme.indexOf("/0.pdf") && !~this.scheme.indexOf("/.pdf");
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