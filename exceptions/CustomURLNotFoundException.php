<?php
class CustomURLNotFoundException extends Exception
{
  public function __construct($code = 0)
  {
    parent::__construct("Custom URL not found", $code);
  }

  public function __toString()
  {
    return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
  }
}
