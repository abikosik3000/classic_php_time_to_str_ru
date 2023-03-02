<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Время в строку</title>
  </head>
  <body>
        <form action="" method="post">
            <p>Часы <input type="text" name="hours"></p>
            <p>Минуты <input type="text" name="minutes"></p>
            <p><input type="submit" value="Отправить"></p>
        </form>
        <div>
            <p>
              <?php 
                require_once("TimeToWordConvert.php");

                //var_dump($_POST);
                if(isset($_POST["hours"]) && isset($_POST["minutes"])){

                  $_POST["minutes"] = htmlspecialchars($_POST["minutes"]);
                  $_POST["hours"] = htmlspecialchars($_POST["hours"]);

                  if(is_numeric($_POST["hours"]) && is_numeric($_POST["minutes"])){

                    $hours =  (int)$_POST["hours"];
                    $minutes =  (int)$_POST["minutes"];
                    if( $hours >= 1 && $hours <= 12 
                        && $minutes >= 0 && $minutes <= 59
                    ){

                      $converter = new TimeToWordConverter();
                      echo "<p>".$converter->convert( $hours, $minutes)."</p>";
                    }
                    else{
                      echo "incorrect num";
                    }

                  }
                  else{
                    echo "field incorrect";
                  }

                }
                /*
                for($h = 1;$h < 13;$h++){
                  for($m = 0;$m < 60;$m++){
                    $converter = new TimeToWordConverter();
                    echo "<p> $h : $m ".$converter->convert( $h, $m)."</p>";
                  }
                }*/
                
              ?>
            </p>
        </div>
   </body>
</html>
