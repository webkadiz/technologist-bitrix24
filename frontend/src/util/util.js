export default class Util {
  static number = [
    "amount",
    "length",
    "width",
    "height",
    "weight",
    "perimeter",
    "square",
    "seamSide1",
    "seamLength1",
    "seamSide2",
    "seamLength2",
    "seamSide3",
    "seamLength3",
    "seamSide4",
    "seamLength4",
    "holeDiameter1",
    "holeOvalX1",
    "holeOvalY1",
    "holeAmount1",
    "holeLength1",
    "holeDiameter2",
    "holeOvalX2",
    "holeOvalY2",
    "holeAmount2",
    "holeLength2",
    "holeDiameter3",
    "holeOvalX3",
    "holeOvalY3",
    "holeAmount3",
    "holeLength3",
    "holeDiameter4",
    "holeOvalX4",
    "holeOvalY4",
    "holeAmount4",
    "holeLength4",
    "holeDiameter5",
    "holeOvalX5",
    "holeOvalY5",
    "holeAmount5",
    "holeLength5"
  ];

  static init(fields) {
    this.fields = fields;
  }

  static checkTree(tree) {
    if (!tree.children || !tree.children.length) return this.checkDetail(tree);

    let res = tree.children.every(child => this.checkTree(child));

    return res && this.checkDetail(tree);
  }

  static checkDetail(detail) {
    let fields = this.fields[detail.type];

    return fields.every(field => this.checkField(detail[field.field], field.field));
  }
  static checkField(field, type) {
    if (field === undefined) return true;
    if (field === null && type.startsWith("labor")) return true;
    if (field === null) return false;

    if (this.number.includes(type)) {
      if (!(!isNaN(parseFloat(field)) && isFinite(field))) return false;
    }

    return true;
  }
  static getErrorField(field, type) {
    if (field === null && type.startsWith("labor")) return "";
    if (field === null) return "заполните поле";

    if (this.number.includes(type)) {
      if (!(!isNaN(parseFloat(field)) && isFinite(field))) return "введите число";
    }

    return "";
  }

  static neutralizeField(field, fieldName) {
    if (field === "") field = null;

    if (this.number.includes(fieldName)) field = parseFloat(field) || field;

    return field;
  }

  static bruteForceTree(detail, { baseCase = () => {}, forEachCase, reduceCase, repeatCase = () => {} }) {
    if (!detail.children && !(detail.children && detail.children.length)) return baseCase(detail);

    let children;

    if (reduceCase) children = detail.children.reduce(reduceCase, 0);
    else if (forEachCase) children = detail.children.forEach(forEachCase);
    else children = false;

    return repeatCase(detail, children);
  }
}
