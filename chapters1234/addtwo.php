<?php
  include_once "../dog.php";
  function addtwo(int $first_value, int $second_value): int {
    $result = $first_value + $second_value;

    return $result;
  }

  $lab = new Dog();
  $lab->display_properties();
/*   print addtwo(12, 14) */
?>