<template>
  <div class="fields">
    <Field :detailId="detailId" v-bind="field" v-for="(field, index) in computeFields" :key="index"></Field>
  </div>
</template>

<script>
import Field from "./field";

export default {
  components: {
    Field
  },
  props: ["detailId"],
  computed: {
    computeFields() {
      let type = this.getDetailField(this.detailId, "type");

      return this.$store.state.fields[type].filter(field => {
        return this.getDetailField(this.detailId, field.field) !== undefined;
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.fields {
  flex-grow: 1;
  margin-top: 30px;
}
</style>