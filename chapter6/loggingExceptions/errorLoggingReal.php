<?php
declare(strict_types=1);

namespace LoggingDogErrors;

class Error_logging {
  const USER_ERROR_LOG = "C:\Program Files (x86)\EasyPHP-Devserver-17\Error_logs\php";
  public $date;
  public $errorType;
  public $eMessage;
  //entire message property
  public $errorMessage;

  function __construct (string $eMessage, string $errorType) {
    $this->date = date('m.d.Y h:i:s');
    $this->errorType = $errorType;
    $this->eMessage = $eMessage;
    $this->errorMessage = $this->date . " | $this->errorType error | " . $this->eMessage."\n";
  }

  function logError() {
    $path = Error_logging::USER_ERROR_LOG ."\\$this->errorType" . date('mdy') . ".log";
    $logBool = error_log($this->errorMessage, 3, $path);

    if (!$logBool) {
      return print "error not logged";
    } 

    return print "Error logged"."<br>";
  }
}
?>
