<?php namespace Gufy\WhmcsPhp;
use ArrayAccess;
class WhmcsResponse implements ArrayAccess
{
  private $response;
  public function __construct($response)
  {
    $this->response = $response;
  }
  public function isSuccess()
  {
    // print_r($this->response);
    return $this->response['result'] == 'success';
  }
  public function __get($var)
  {
    return $this->response[$var];
  }
  public function offsetGet($var)
  {
    return $this->response[$var];
  }
  public function offsetSet($var, $value)
  {
    return $this->response[$var] = $value;;
  }
  public function offsetExists($var)
  {
    return isset($this->response[$var]);
  }
  public function offsetUnset($var)
  {
    unset($this->response[$var]);
    return $this;
  }
}
