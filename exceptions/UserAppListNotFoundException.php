<?php
class UserAppListNotFoundException extends Exception
{
  public function __construct()
  {
    parent::__construct("User's list of owned apps not found");
  }

  public function __toString()
  {
    return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
  }
}
