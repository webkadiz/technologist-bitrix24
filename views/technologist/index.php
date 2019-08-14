<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title></title>
  </head>

  <body>
    <div id="app"></div>


    <script>
    
    BX24.install(function() {
      console.log(123);
      fetch("/technologist/install")
        .then(res => res.json())
        .then(data => {
          if(data.error) {
            document.querySelector('#app').innerHTML = '<div>ошибка при установке, повторите попытку</div>'
            return
          }

          document.querySelector('#app').innerHTML = '<div>установка прошла успешно</div>'
          BX24.installFinish();
        }).catch(err => {
           document.querySelector('#app').innerHTML = '<div>ошибка при установке, повторите попытку</div>'
        })
      
    });

    </script>
  </body>
</html>
