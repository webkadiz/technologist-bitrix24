class BaseError extends Error {
  constructor(message, vm) {
    super(message)
    this.vm = vm
    this.name = this.constructor.name
    this.errors = this.vm ? this.vm.$store.state.errors : []
    
    let id = _.last(this.errors) && _.last(this.errors).id + 1 || 1

    this.errors.push({
      id,
      message,
      type: this.name,
      isServed: false
    })
  }
}

class JsonError extends BaseError {
}

export {JsonError}