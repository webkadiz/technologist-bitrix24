class BaseError extends Error {
  constructor(store, message) {
    super(message)
    this.store = store
    this.name = this.constructor.name
    this.errors = this.store ? this.store.state.errors : []

    let id = _.last(this.errors) && _.last(this.errors).id + 1 || 1

    this.errors.push({
      id,
      message,
      type: this.name,
      isNonServed: true
    })
  }
}

class JsonError extends BaseError {
  constructor(store, data, message = 'Сервер вернул данные в неправильном формате') {
    super(store, message)
    console.log(data)
  }
}

class LogicError extends BaseError {
  constructor(store, message = 'Произошла ошибка приложения') {
    super(store, message)
  }
}

class ServerError extends BaseError {
  constructor(store, message = 'Сервер недоступен') {
    super(store, message)
  }
}

export { BaseError, LogicError, JsonError, ServerError }