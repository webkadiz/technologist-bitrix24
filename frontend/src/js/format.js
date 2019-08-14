export default class Format {
  constructor(context) {
    this.string = ["profile"];
    this.number = ["length", "width", "height", "pureWeight", "refusal", "weight", "square"];
  }
  check(value, type) {
    if (value === null) return "Заполните поле";

    if (this.number.includes(type) && value !== "") {
      if (!(!isNaN(parseFloat(value)) && isFinite(value))) return "Введите число";
    }

    return "";
  }
  cast(value, type) {
    if (!value) return value;

    if (this.number.includes(type)) {
      value = parseFloat(value);
    }

    return value;
  }
}
