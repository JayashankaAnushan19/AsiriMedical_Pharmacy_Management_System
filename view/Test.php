<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
session_start();

$_SESSION["favcolor"] = "green";
$_SESSION["favanimal"] = "cat";
echo "Session variables are set.";


// Echo session variables that were set on previous page
echo "Favorite color is " . $_SESSION["favcolor"] . ".<br>";
echo "Favorite animal is " . $_SESSION["favanimal"] . ".". "<br>";;
?>


<?php
$cars = array("Volvo", "BMW", "Toyota" , "Indica" , "Bajaj"); 
echo count($cars) . "<br>";

// $n = 0;
$count = (count($cars));

$x = 0;

while($x < $count) {
  echo "The number is: $cars[$x] <br>";
  $x++;
}

echo "<br><br><br>";

// Class Make and use ----  Need to make class on need page and then use it.
class Fruit {
  public $nameJJ;
  public $color;

  function __construct($name, $color) {
    $this->name = $name;
    $this->color = $color;
  }
  function get_name() {
    return $this->name;
  }
  function get_color() {
    return $this->color;
  }
}

$apple = new Fruit("Apple", "red");
echo $apple->get_name();
echo "<br>";
echo $apple->get_color();




?>


</body>
</html>