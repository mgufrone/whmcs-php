<?php namespace Gufy\WhmcsPhp\Exceptions;
use Exception;
class ReadOnlyException extends Exception
{
  public function __construct($message, $code=0, Exception $previous=null)
  {
    $message = "You are not allowed to override this key : ".$message;
    parent::__construct($message, $code, $previous);
  }
}
