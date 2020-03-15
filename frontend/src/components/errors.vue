<template>
  <Snackbar
    v-if="currentError"
    v-bind="optionsForSnackbar "
    :labelText="currentError.message"
    :snackID="currentError.id"
    @closed="closed"
  />
</template>

<script>
import { mapMutations } from 'vuex'
import Snackbar from "./snackbar";

export default {
  components: { Snackbar },
  watch: {
    storeErrors() {
      let nonServedErrors = this.storeErrors.filter(
        error => error.isNonServed
      );

      let difference = _.differenceBy(nonServedErrors, this.localErrors);
      
      this.localErrors = this.localErrors.concat(difference);
    }
  },
  methods: {
    closed(reason) {
      let error = this.localErrors.shift()
      this.makeErrorIsServed(error.id)
    },
    ...mapMutations(['makeErrorIsServed'])
  },
  computed: {
    storeErrors() {
      return this.$store.state.errors
    },
    currentError() {
      return this.localErrors[0]
    }
  },
  data() {
    return {
      localErrors: [],
      optionsForSnackbar: {
        actionButtonText: 'OK',
        timeoutMs: 4000
      }
    };
  }
};
</script>

<style>
</style>
