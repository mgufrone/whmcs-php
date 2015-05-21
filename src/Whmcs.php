<?php namespace Gufy\WhmcsPhp;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Gufy\WhmcsPhp\Exceptions\ResponseException;
use Closure;
class Whmcs
{
  private $callbacks = [];
  public function __construct(Config $config)
  {
    $this->config =& $config;
  }
  public function execute($action, $parameters=[])
  {
    $client = new Client;
    $this->beforeExecute($client);
    $parameters['action'] = $action;
    $parameters['username'] = $this->config->getUsername();
    $parameters['password'] = $this->config->getPassword();
    $parameters['responsetype'] = 'json';
    try
    {
      $response = $client->post($this->config->getBaseUrl(), ['body'=>$parameters,'timeout' => 1200,'connect_timeout' => 10]);

      return $this->processResponse($response->json());
    }
    catch(ClientException $e)
    {
      $response = $e->getResponse()->json();
      throw new ResponseException($response['message']);
    }
  }
  public function beforeExecute(Client &$client)
  {
    foreach($this->callbacks as $closure)
    {
      $closure($client);
    }
    return $this;
  }
  public function setBeforeExecute(Closure $callback)
  {
    return $this->callbacks[] = $callback;
  }
  public function processResponse($response)
  {
    return new WhmcsResponse($response);
  }
  public function __call($function, array $arguments=[])
  {
    return call_user_func_array([$this, 'execute'], [$function, $arguments]);
  }
}
