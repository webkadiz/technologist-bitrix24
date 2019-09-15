<template>
  <div class="field input-field" :class="fieldClasses">
    <input
      @input="input"
      @focus="focus"
      @blur="blur"
      ref="input"
      type="text"
      class="field__input"
      :value="value"
      :class="inputClasses"
      :disabled="disabled"
    >
    <label class="field__label">{{_.capitalize(label)}}</label>
    <small class="helper-text" :data-error="_.capitalize(error)"></small>
  </div>
</template>

<script>
import _ from 'lodash'

export default {
  props: ["value", "disabled", "error", "label"],
  computed: {
    inputClasses() {
      if (this.disabled) return;

      return {
        [this.error ? "invalid" : "valid"]: true
      };
    },
    fieldClasses() {
      return {
        field_disabled: this.disabled,
        [this.error ? "field_invalid" : "field_valid"]: true
      };
    }
  },
  mounted() {
    this.notEmpty = this.value;
    M.updateTextFields();
  },
  watch: {
    value() {
      this.notEmpty = this.value;
      if (this.$refs.input) {
        if (document.querySelector(":focus") === this.$refs.input)
          this.notEmpty = true;
      }
    }
  },
  methods: {
    input(e) {
      this.$emit("input", e.target.value);
    },
    focus() {
      this.notEmpty = true;
    },
    blur() {
      this.notEmpty = this.value;
    }
  },
  data() {
    return {
      notEmpty: false
    };
  }
};
</script>

<style lang="scss" scoped>
.field_width_100 {
  flex-basis: 100%;
}

// .field__input {
//   outline: none;
//   border: none;
//   background: transparent;
//   width: 100%;
//   //border-bottom: 1px solid #dee2e6;
//   display: block;
//   //padding-left: 15px;
//   //padding-bottom: 6px;
//   font-size: 0.9em;
// }

// .field__input_active + label {
//   transform: translateY(-25px);
//   font-size: 0.8em;
// }

// .field__label {
//   text-transform: uppercase;
//   margin: 0;
//   padding-bottom: 4px;
//   padding-left: 15px;
//   transition: 0.3s;
//   font-size: 1em;
//   display: block;
//   position: absolute;
//   bottom: 0;
//   pointer-events: none;
//   white-space: nowrap;
//   width: 100%;
//   overflow: hidden;
//   text-overflow: ellipsis;
// }

// .field__error {
//   color: var(--danger);
//   position: absolute;
//   top: 100%;
//   padding-left: 15px;
//   display: block;
//   line-height: 1.2;
//   width: 100%;
//   overflow: hidden;
//   text-overflow: ellipsis;
// }

// .field_invalid .field__input {
//   border-bottom: 1px solid var(--danger);
// }

// .field_invalid .field__label {
//   color: var(--danger);
// }

// .field_valid .field__input {
//   border-bottom: 1px solid var(--success);
// }

// .field_valid .field__label {
//   color: var(--success);
// }

// .field_valid .field__error {
//   display: none;
// }

// .field_disabled .field__input {
//   border-bottom: 1px solid #7f8c8d;
// }

// .field_disabled .field__label {
//   color: #7f8c8d;
// }

// .field_unchecked .field__error {
//   display: none;
// }
</style>