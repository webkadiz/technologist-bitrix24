<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title><?= $this->title ?></title>

</head>

<body>
  <div id="app">
    <header-panel></header-panel>
    <library :detail-list="$store.state.detailList"></library>
    <report></report>
    <errors></errors>
  </div>

  <script src="//api.bitrix24.com/api/v1/"></script>
  <script src="http://localhost:8080/js/technologist.js"></script>
</body>

</html>