<template>
  <field-input
    @input="inputValue"
    :label="label"
    :disabled="disabled"
    :value="computeValue"
    :error="fieldError"
    :field="field"
    v-if="!checkbox"
  ></field-input>
  <field-checkbox
    @input="inputValue"
    :label="label"
    :disabled="disabled"
    :value="computeValue"
    :error="fieldError"
    :field="field"
    :checkboxLabel="checkboxLabel"
    v-else
  ></field-checkbox>
</template>

<script>
import FieldInput from "./field-input";
import FieldCheckbox from "./filed-checkbox";

export default {
  components: {
    FieldInput,
    FieldCheckbox
  },
  props: [
    "detailId",
    "field",
    "depend",
    "label",
    "disabled",
    "checkbox",
    "checkboxLabel"
  ],
  methods: {
    inputValue(value) {
      this.setDetailField({
        depend: this.depend,
        id: this.detailId,
        value,
        field: this.field
      });
    },
    ...Vuex.mapMutations(["setDetailField"])
  },
  computed: {
    computeValue() {
      //prettier-ignore
      let value = this.getDetailField(this.detailId, this.field);

      this.fieldError = Util.getErrorField(value, this.field);

      return value;
    },
    ...Vuex.mapGetters(["getDetailField"])
  },
  data() {
    return {
      fieldError: ""
    };
  }
};
</script>

<style lang="scss">
.field {
  flex-basis: 45%;
}
</style>