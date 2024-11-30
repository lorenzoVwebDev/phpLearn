<?php declare(strict_types=1);

  class Dog {
    private int $dog_weight = 0;
    private string $dog_breed = "no breed";
    private string $dog_color = "no color";
    private string $dog_name = "no name";
    function get_properties() {
      return "$this->dog_weight, $this->dog_breed, $this->dog_color";
    }

    function set_dog_name(string $value): bool {
      $error_message = TRUE;
      //ctype_alpha() checks whether a string is compose made exclusively of alphabetic characters (not whitespaces, numbers etc.)
      //ctype_digit() checks whether a string is compose made exclusively of digits (0-9)
      //strlen() return the number of character of a given string 
      (ctype_alpha($value) && strlen($value) < 21) ? $this->dog_name =$value : $error_message = FALSE;
      return $error_message;
    }
  }
?>