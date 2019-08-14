<?php

return [
  'detail' => [
    ['label' => "материал", 'field' => "stuff"],
    ['label' => "толщина", 'field' => "thickness"],
    ['label' => "профиль", 'field' => "profile"],
    ['label' => "длина (мм)", 'field' => "length"],
    ['label' => "ширина (мм)", 'field' => "width"],
    ['label' => "высота (мм)", 'field' => "height"],
    ['label' => "марка стали", 'field' => "steel"],
    ['label' => "масса (кг)", 'field' => "weight"],
    ['label' => "периметр (м)", 'field' => "perimeter"],
    ['label' => "площадь (м кв.)", 'field' => "square"],
    ['label' => "катет сварки 1 (мм)", 'field' => "seamSide1"],
    ['label' => "L шва сварки 1 (м)", 'field' => "seamLength1"],
    ['label' => "катет сварки 2 (мм)", 'field' => "seamSide2"],
    ['label' => "L шва сварки 2 (м)", 'field' => "seamLength2"],
    ['label' => "катет сварки 3 (мм)", 'field' => "seamSide3"],
    ['label' => "L шва сварки 3 (м)", 'field' => "seamLength3"],
    ['label' => "катет сварки 4 (мм)", 'field' => "seamSide4"],
    ['label' => "L шва сварки 4 (м)", 'field' => "seamLength4"],
    ['label' => "отверстия круглые, диаметр 1", 'field' => "holeDiameter1"],
    ['label' => "отверстия овальные, по оси X 1", 'field' => "holeOvalX1"],
    ['label' => "отверстия овальные, по оси Y 1", 'field' => "holeOvalY1"],
    ['label' => "количество отверстий 1", 'field' => "holeAmount1"],
    ['label' => "длина реза 1", 'field' => "holeLength1"],
    ['label' => "отверстия круглые, диаметр 2", 'field' => "holeDiameter2"],
    ['label' => "отверстия овальные, по оси X 2", 'field' => "holeOvalX2"],
    ['label' => "отверстия овальные, по оси Y 2", 'field' => "holeOvalY2"],
    ['label' => "количество отверстий 2", 'field' => "holeAmount2"],
    ['label' => "длина реза 2", 'field' => "holeLength2"],
    ['label' => "отверстия круглые, диаметр 3", 'field' => "holeDiameter3"],
    ['label' => "отверстия овальные, по оси X 3", 'field' => "holeOvalX3"],
    ['label' => "отверстия овальные, по оси Y 3", 'field' => "holeOvalY3"],
    ['label' => "количество отверстий 3", 'field' => "holeAmount3"],
    ['label' => "длина реза 3", 'field' => "holeLength3"],
    ['label' => "отверстия круглые, диаметр 4", 'field' => "holeDiameter4"],
    ['label' => "отверстия овальные, по оси X 4", 'field' => "holeOvalX4"],
    ['label' => "отверстия овальные, по оси Y 4", 'field' => "holeOvalY4"],
    ['label' => "количество отверстий 4", 'field' => "holeAmount4"],
    ['label' => "длина реза 4", 'field' => "holeLength4"],
    ['label' => "отверстия круглые, диаметр 5", 'field' => "holeDiameter5"],
    ['label' => "отверстия овальные, по оси X 5", 'field' => "holeOvalX5"],
    ['label' => "отверстия овальные, по оси Y 5", 'field' => "holeOvalY5"],
    ['label' => "количество отверстий 5", 'field' => "holeAmount5"],
    ['label' => "длина реза 5", 'field' => "holeLength5"],
    ['label' => "количество деталей", 'field' => "amount"],

  ],
  'assembly' => [
    ['label' => "материал", 'field' => "category"],
    ['label' => "количество деталей", 'field' => "amount"],
    ['label' => "длина (мм)", 'field' => "length"],
    ['label' => "ширина (мм)", 'field' => "width"],
    ['label' => "высота (мм)", 'field' => "height"],
    ['label' => "масса (кг)", 'field' => "weight"]
  ],
  'hardware' => [
    ['label' => "гост", 'disabled' => true, 'field' => "gost"],
    ['label' => "количество", 'disabled' => true, 'field' => "amount"],
    ['label' => "масса", 'disabled' => true, 'field' => "weight"],
    [
      'label' => "масса (1000 кг)",
      'disabled' => true,
      'field' => "weightThousand"
    ],
    ['label' => "примечания", 'disabled' => true, 'field' => "note"]
  ]

];