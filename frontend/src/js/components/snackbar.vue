<template>
  
  <m-snackbar
    @closed="closed"
    @change="change"
    v-bind="options"
    :labelText="labelText"
    v-model="computeIsSnackbarOpen"
  />
 
</template>

<script>
import "material-components-vue/dist/snackbar";

export default {
  props: {
    isSnackbarOpen: Boolean,
    labelText: String
  },
  computed: {
    computeIsSnackbarOpen: {
      get() {
        
        return this.isSnackbarOpen
      },
      set(data) {
        this.isSnackbarOpen = data
        console.log(data, 'set', this.labelText)
      }
    }
  },
  mounted() {
    console.log(this.computeIsSnackbarOpen)
  },
  data() {
    return {
      options: {
        //labelText: 'hello wolrd',
        actionHandler: () => console.log("snackbar action"),
        actionButtonText: "ok",
        multiline: false,
        actionOnBottom: false,
        hasDismiss: true
      }
    };
  },
  methods: {
    change(val) {
      console.log('change methodss', val)
      this.computeIsSnackbarOpen = true
      console.log(this.isSnackbarOpen)
      //this.isSnackbarOpen = true
    },
    closed({ reason }) {
      this.computeIsSnackbarOpen = false
      this.$emit('closed', reason);
      console.log('closed', reason)
    }
  }
};
</script>

<style lang="scss">
@import "material-components-vue/dist/snackbar/styles";
</style>

