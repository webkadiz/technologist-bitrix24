<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title><?php echo $title ?></title>

  <?php echo $css ?>
</head>

<body>
  <div id="app">
    <header-panel></header-panel>
    <library :detail-list="$store.state.detailList"></library>
    <report></report>
  </div>

  <script src="//api.bitrix24.com/api/v1/"></script>

  <?php echo $js ?>
</body>

</html>