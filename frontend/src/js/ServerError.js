export default class ServerError extends Error {
  constructor(err) {
    super();

    this.name = "ServerError";
    this.message = err.errorMessage;
  }
}
