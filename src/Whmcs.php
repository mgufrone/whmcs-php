<?php namespace Gufy\WhmcsPhp;
use GuzzleHttp\Client;
class Whmcs
{
  public function __construct(Config $config)
  {
    $this->config = $config;
  }
  public function execute($action, $parameters=[])
  {
    $client = new Client;
    $parameters['action'] = $action;
    $parameters['username'] = $this->config->getUsername();
    $parameters['password'] = $this->config->getPassword();
    $parameters['responsetype'] = $this->config->getResponseType();
    try
    {
      $response = $client->post($this->config->getBaseUrl(), ['body'=>$parameters,'timeout' => 1200,'connect_timeout' => 10]);

      try
      {
        return $this->processResponse($response->json());
      }
      catch(ParseException $e)
      {
        return $this->processResponse($response->xml());
      }
    }
    catch(ClientException $e)
    {
      $response = $e->getResponse()->json();
      throw new Exception($response['message']);
    }
  }
  public function processResponse($response)
  {
    return new WhmcsResponse($response);
  }
  public function __call($function, $arguments=[])
  {
    // $arguments['action'] =
    return call_user_func_array([$this, 'execute'], [$function, $arguments]);
  }
}
