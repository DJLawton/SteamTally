<?php
class CurlRequestFailedException extends Exception
{
  public function __construct($code = 0)
  {
    parent::__construct("Request failed", $code);
  }

  public function __toString()
  {
    return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
  }
}
