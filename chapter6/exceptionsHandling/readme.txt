#chapter 6: Handling and Logging Exceptions
Errors: program events that are handled by the system that cause the program to shut down. They are usually events beyond the control of the program, such as insufficient memory.
Exceptions: are events out of the normal flow of the program logic, such as missing files, entering invalid information. Then they are determined to be corrected, ignored, or if the application must shut down. If a program does not catch exceptions, the system displays the exception message and then shut down the application.

Errors/exceptions flow:

When an Errors/exception occurs, the system will look in order into:
Class;
Instance of the Class (object);
The process will continue until either a catch block has been discovered or the environment itself must handle the exception.

Logging:
  We should put error messages into log files.
  PHP jas a default error file where all errors/exceptions are logged in. However, we can modify the php.ini file in order to modify the location and the name of this default file
  
Types of log files:
  informational log files
  authentication (login) log fileserror
  error log files
  security log files

Logs format:
  max 120 characters,
  time/date,
  type of message(if there is more than one message type in the file),
  other pertinent information

  Log files must be placed into the same folder

Exception hiding (important):
  before the deployment process, we should change the "display_errors = On" to "Off" in the php.ini, this hides the errors to the users, errors should be kept hided to be viewed just by the personnell

Programs that retrieve data that will be used throughout the program usually retrieve the information in the initial stages of the code and place it in a data structure.
As the data is updated in the program, the information in the the data structure is updated.
When the data processing has been completed, the information is then returned to the original location. 
Updating a log file or a database is usually one of the latest processes of a project.