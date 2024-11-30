<?php 
declare(strict_types=1);
require 'mailService.php';
require '../loggingExceptions/errorLoggingReal.php';

//if you are using a function instead of a class in a namespace then you have to declare it as you see below
use function MailerSystem\sendMail;
use LoggingDogErrors\Error_logging;

const USER_ERROR_LOG = "User_Errors.log";
const ERROR_LOG = "Errors.log";

/* class setException extends Exception {
  public function errorMessage() : string {
  list($name_error, $breed_error, $color_error, $weight_error) =
  explode(',', $this->getMessage());
  string $name_error == 'TRUE' ? $eMessage = '' : $eMessage =
  'Name update not successful<br/>';
  string $breed_error == 'TRUE' ? $eMessage .= '' : $eMessage .=
  'Breed update not successful<br/>';
  string $color_error == 'TRUE' ? $eMessage .= '' : $eMessage .=
  'Color update not successful<br/>';
  string $weight_error == 'TRUE' ? $eMessage .= '' : $eMessage .=
  'Weight update not successful<br/>';
  string return $eMessage;
  }
} */


function get_properties($lab) {
  print "Your dog's name is " . $lab->get_dog_name() . "<br/>";
  print "Your dog weights " . $lab->get_dog_weight() . " lbs. <br />";
  print "Your dog's breed is " . $lab->get_dog_breed() . "<br />";
  print "Your dog's color is " . $lab->get_dog_color() . "<br />";
}
//----------------Main Section-------------------------------------
try {
  throw new Error('Error test dog interface');
/*   if ( file_exists("e5dog_container.php")) {
    Require_once("e5dog_container.php");
  } else {
    throw new Exception("Dog container file missing or corrupt");
  } */

/* if (isset($_POST['dog_app'])) {
  if ((isset($_POST['dog_name'])) && (isset($_POST['dog_breed'])) &&
  (isset($_POST['dog_color'])) && (isset($_POST['dog_weight']))) {
    $container = new dog_container(filter_var($_POST['dog_app'],
    FILTER_SANITIZE_STRING));
    string $dog_name = filter_var( $_POST['dog_name'],
    FILTER_SANITIZE_STRING);
    string $dog_breed = filter_var( $_POST['dog_breed'],
    FILTER_SANITIZE_STRING);
    string $dog_color = filter_var( $_POST['dog_color'],
    FILTER_SANITIZE_STRING);
    string $dog_weight = filter_var( $_POST['dog_weight'],
    FILTER_SANITIZE_STRING);
    $breedxml = $container->get_dog_application("breeds");
    $properties_array = array($dog_name,$dog_breed,$dog_color,
    $dog_weight,$breedxml);
    $lab = $container->create_object($properties_array);
    print "Updates successful<br />";
    get_properties($lab);
  } else {
    
    print "<p>Missing or invalid parameters. Please
    go back to the dog.html page to enter valid
    information.<br />";
    print "<a href='dog.html'>Dog Creation
    Page</a>";
  }} else {

    $container = new dog_container("selectbox");
    $properties_array = array("selectbox");
    $lab = $container->create_object($properties_array);
    $container->set_app("breeds");
    $dog_app = $container->get_dog_application("breeds");
    $result = $lab->get_select($dog_app);
    print $result;

  } */} catch(setException $e) {
    //user errors: useful to tracking trends of user problems
    echo $e->errorMessage(); // displays to the user
    $date = date('m.d.Y h:i:s');
    $errormessage = $e->errorMessage();
    $eMessage = $date . " | User Error | " . $errormessage . "\n";
    error_log($eMessage, 3, USER_ERROR_LOG); // writes message to
  } catch (Error $e) {

    echo "Error. The system is currently unavailable. Please try again
    later.";
    // displays message to the user
    $date = date('m.d.Y h:i:s');
    $errormessage = $e->getMessage();
    $eMessage = $date . " | Fatal System Error | " .
    $errormessage . "\n";
    //logging message
    $errorLog = new Error_logging($eMessage, "System error");
    // e-mails personnel to alert them of a system problem
    $errorLog->logError();
    sendMail($date, $eMessage);
  } catch(Throwable $t) {

    echo "The system is currently unavailable. Please try again
    later.";
    // displays message to the user
    $date = date('m.d.Y h:i:s');
    $errormessage = $t->getMessage();
    $eMessage = $date . " | User Error | " . $errormessage . "\n";
    error_log($eMessage,3,ERROR_LOG); // writes message to

    error_log("Date/Time: $date - Serious System Problems with Dog
    Application. Check error log for details", 1, "noone@helpme.
    com", "Subject: Dog Application Error \nFrom: System Log
    <systemlog@helpme.com>" . "\r\n");
    // e-mails personnel to alert them of a system problem
  }