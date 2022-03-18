<?php
class UserNotFoundException extends Exception
{
  public function __construct()
  {
    parent::__construct("User not found");
  }

  public function __toString()
  {
    return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
  }
}
