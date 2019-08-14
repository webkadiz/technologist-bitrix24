<template>
  <Snackbar v-if="errors.length" :isSnackbarOpen="errors[0].isServed" :labelText="errors[0].message" @closed="closed"/>

</template>

<script>
import Snackbar from './snackbar'

export default {
  components: { Snackbar },
  watch: {
    '$store.state.errors': function() {
      this.$nextTick(() => {
        
        console.log('errors change')
        let nonServedErrors = this.$store.state.errors.filter(error => !error.isServed)
        let difference = _.differenceBy(nonServedErrors, this.errors)
        console.log(nonServedErrors)
        console.log(difference)
        this.errors = this.errors.concat(difference)
  
        console.log(this.errors)   
        })
    }
  },
  methods: {
    closed(reason) {
      console.log(this.errors)
      this.errors.shift()
      //this.$forceUpdate()
    }
  },
  data() {
    return {
      errors: []
    }
  }
}
</script>

<style>

</style>