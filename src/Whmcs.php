<?php namespace Gufy\WhmcsPhp;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Gufy\WhmcsPhp\Exceptions\ResponseException;
use Closure;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
class Whmcs
{
  private $callbacks = [];
  static $CLIENT;
  private $request;
  public function __construct(Config $config)
  {
    $this->config =& $config;
  }
  public function client($config = []){
    if(self::$CLIENT == null){
      $config = array_merge($config, []);
      self::$CLIENT = new Client($config);
    }
    return self::$CLIENT;
  }
  public function execute($action, $args=[])
  {
    $parameters = $args[0];
    $class = $this;
    $tapHandler = Middleware::tap(function(RequestInterface $request) use($class){
      $class->setRequest($request);
    });
    $client = $this->client();
    $clientHandler = $client->getConfig("handler");
    $parameters['action'] = $action;
    $parameters['username'] = $this->config->getUsername();
    if($this->config->getAuthType() == 'password')
      $parameters['password'] = $this->config->getPassword();
    elseif($this->config->getAuthType() == 'keys')
      $parameters['accesskey'] = $this->config->getPassword();
    $parameters['responsetype'] = 'json';
    try
    {
      $response = $client->post($this->config->getBaseUrl(), ['form_params'=>$parameters,'timeout' => 1200,'connect_timeout' => 10,'handler'=>$tapHandler($clientHandler)]);
      return $this->processResponse(json_decode($response->getBody()->getContents(), true));
    }
    catch(ClientException $e)
    {
      $response = json_decode($e->getResponse()->getBody()->getContents(), true);
      throw new ResponseException($response['message']);
    }
  }
  public function setRequest(RequestInterface $request){
    $this->request = $request;
  }
  public function getRequest(){
    return $this->request;
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
