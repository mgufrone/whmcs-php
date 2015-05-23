<?php namespace Gufy\WhmcsPhp;
use GuzzleHttp\Client;
class Config
{
  private $baseUrl = 'http://localhost/includes/api.php';
  private $username = '';
  private $password = '';
  private $authType = 'password';
  private $responseType = 'json';
  private $response = 'object';
  public function __construct(array $config=[])
  {
    foreach($config as $key=>&$value)
    {
      $this->$key = $value;
    }
    return $this;
  }
  public function getBaseUrl()
  {
    return $this->baseUrl;
  }
  public function setBaseUrl($url)
  {
    $this->baseUrl = $url;
    return $this;
  }
  public function getUsername()
  {
    return $this->username;
  }
  public function setUsername($username)
  {
    $this->username = $username;
    return $this;
  }
  public function getPassword()
  {
    return $this->authType == 'password'? md5($this->password) : $this->password;
  }
  public function setPassword($password)
  {
    $this->password = $password;
    return $this;
  }
  public function getResponseType()
  {
    return $this->responseType;
  }
  public function setResponseType($responseType)
  {
    $this->responseType = $responseType;
    return $this;
  }
  public function getResponse()
  {
    return $this->response;
  }
  public function setResponse($response)
  {
    $this->response = $response;
    return $this;
  }
  public function getAuthType()
  {
    return $this->authType;
  }
  public function useApiKeys($apiKey = '')
  {
    $this->authType = 'keys';
    $this->setPassword($apiKey);
    return $this;
  }
  public function usePassword($password='')
  {
    $this->authType = 'password';
    $this->setPassword($password);
    return $this;
  }
}
