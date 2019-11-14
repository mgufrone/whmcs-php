<?php namespace Gufy\WhmcsPhp;
use ArrayAccess;
use Gufy\WhmcsPhp\Exceptions\ResponseException;
use Gufy\WhmcsPhp\Exceptions\ReadOnlyException;
class WhmcsResponse implements ArrayAccess
{
  private $response;
  public function __construct($response)
  {
    $this->response = $response;
    if(false === $this->isSuccess())
    throw new ResponseException($this->message);
  }
  public function isSuccess()
  {
    return isset($this->result) && $this->result == 'success';
  }
  public function __get($var)
  {
    return $this->response[$var];
  }
  public function offsetGet($var)
  {
    return $this->response[$var];
  }
  public function offsetSet($var, $value='')
  {
    throw new ReadOnlyException($var);
  }
  public function offsetExists($var)
  {
    return isset($this->response[$var]);
  }
  public function offsetUnset($var)
  {
    throw new ReadOnlyException($var);
  }
}
