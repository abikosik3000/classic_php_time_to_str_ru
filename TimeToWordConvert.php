<?php

interface TimeToWordConvertinginterface
{

public function convert(int $hours, int $minutes): string;

}

class TimeToWordConverter implements TimeToWordConvertinginterface{
  
  private $unit = array(
    'male' => array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
    'female' => array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять')
  );
  private $tens20 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать',
   'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
  private $tens = array('' , '' , 'двадцать', 'тридцать', 'сорок', 'пятьдесят');
  private $genitive_hours = array('двенадцати' ,'часа', 'двух', 'трёх', 'четырёх', 'пяти', 'шести',
   'семи', 'восьми', 'девяти', 'десяти', 'одинадцати', 'двенадцати','часа');
  private $genitive_part_of = array('двенадцатого' ,'первого', 'второго', 'третьего', 'четвертого', 'пятого', 'шестого',
   'седьмого', 'восьмого', 'девятого', 'десятого', 'одинадцатого', 'двенадцатого','первого');
  
  private function slovoform(int $n,array $dict_slovoform ): string
  {
    /**
     * return slovoform in ru lang for num n
     */
    if ($n >= 10 && $n <= 20) return $dict_slovoform[2];
    $n = $n % 10;
    if ($n <= 1) return $dict_slovoform[0];
    if ($n > 1 && $n < 5) return $dict_slovoform[1];
    return $dict_slovoform[2];
  }

  private function num_to_str(int $num , string $gender): string{
    /**
     * number to string in ru lang used gender
     * num in [1 , 59]
     */
    $ret = [];
    $units = $num % 10;
    $tenth = intdiv($num , 10);
    if($tenth == 1){
        $ret[] = $this->tens20[$units];
    }
    else{
        $ret[] = $this->tens[$tenth];
        $ret[] = $this->unit[$gender][$units];
      
    }
    return trim( join(' ', $ret));;
  }

  public function convert(int $hours, int $minutes): string{
    $out = array();
    
    #print minutes part
    if($minutes == 15){
      $out[] = "четверть";
    }
    else if($minutes == 30){
      $out[] = "половина";
    }
    else if($minutes > 0){
      $_minutes_print = ($minutes < 30) ? $minutes : 60 - $minutes;
      $out[] = $this->num_to_str( $_minutes_print , 'female');
      $out[] = $this->slovoform( $_minutes_print, array('минута' , 'минуты', 'минут'));
      $out[] = ($minutes < 30) ? "после" : "до";
    }

    #print hours part
    if($minutes == 0){
      if($hours != 1){
        $out[] = $this->num_to_str( $hours , "male");
      }
      $out[] = $this->slovoform( $hours, array('час' , 'часа', 'часов'));
    }
    else if($minutes == 30 || $minutes == 15 ){
      $out[] = $this->genitive_part_of[$hours + 1];
    }
    else{
      $_hours_print = ($minutes < 30) ? $hours : $hours + 1;
      $out[] = $this->genitive_hours[$_hours_print];
    }
     
    #convert answer
    $ret_str = trim( join(' ', $out).".");
    $fc_upper = mb_strtoupper(mb_substr($ret_str, 0, 1));
    return $fc_upper.mb_substr($ret_str, 1);
  }
}
