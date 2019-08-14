<template>
	<div class="custom-control custom-checkbox field field__checkbox">
    <input ref="checkbox" type="checkbox" class="custom-control-input" :checked="isChecked">
    <label @click="toggleCheckbox" class="custom-control-label field__checkbox-label">{{checkboxLabel}}</label>
    <transition name="fade-checkbox">
      <FieldInput v-if="isShowLabor" class="field__checkbox-input" :value="value" :error="error" :label="label" @input="$emit('input', $event)"></FieldInput>
    </transition>
  </div>
</template>

<script>
import FieldInput from './field-input';

export default {
	components: {
		FieldInput
	},
	props: ['value', 'error', 'label', 'checkboxLabel'],
	mounted() {
		if(this.value) {
			this.isShowLabor = true;
			this.isChecked = true;
		}
	},
	methods: {
		toggleCheckbox() {
			if(this.isShowLabor) {
				this.$emit('input', '');
			}

			this.isChecked = !this.isChecked
			this.isShowLabor = !this.isShowLabor   
    },
	},
	computed: {
		isShowLaborCompute() {
			return true
		}
	},
	data() {
		return {
			isShowLabor: false,
			isChecked: false
		}
	}
}
</script>

<style lang="scss" scoped>
.field__checkbox {
  cursor: pointer;
  flex-basis: 100%;
  display: flex;
  color: #5a427f;
}

.field__checkbox-label {
	text-transform: uppercase;
	width: 300px;
}

.custom-control-label, .custom-control-label:before, .custom-control-label:after {
	cursor: pointer;
}

.field__checkbox-input {
	width: 100%;
  margin-bottom: 0;
}

.fade-checkbox-enter-active,
.fade-checkbox-leave-active {
  transition: 0.5s;
}

.fade-checkbox-enter,
.fade-checkbox-leave-to {
  opacity: 0;
}
</style>