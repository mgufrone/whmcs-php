<?php
use Gufy\WhmcsPhp\Config;
use Gufy\WhmcsPhp\Whmcs;
use Gufy\WhmcsPhp\WhmcsResponse;
use Aeris\GuzzleHttpMock\Mock as HttpMock;
use GuzzleHttp\Client;
class WhmcsTest extends PHPUnit_Framework_TestCase
{
  public $whmcs;
  public function setUp()
  {
    parent::setUp();
    $this->config = new Config([
      'baseUrl'=>'http://localhost/includes/api.php',
      'username'=>'gufron',
      'password'=>'jago4n123',
    ]);
    $this->whmcs =  new Whmcs($this->config);
    $this->whmcs->setBeforeExecute(function(Client $client){
      $httpMock = new HttpMock();
      $httpMock->attachToClient($client);

      // Setup a request expectation
      $httpMock
          ->shouldReceiveRequest()
          ->withUrl('http://localhost/includes/api.php')
          ->withMethod('POST')
          ->withBodyParams([ 'action' => 'getclients', 'username'=>'gufron','password'=>md5('jago4n123'),'responsetype'=>'json' ])
          ->andRespondWithJson([ 'result'=>'success','clients'=>['client'=>[]] ], $statusCode = 200);

      $httpMock = new HttpMock();
      $httpMock->attachToClient($client);
      $httpMock
          ->shouldReceiveRequest()
          ->withUrl('http://localhost/includes/api.php')
          ->withMethod('POST')
          ->withBodyParams([ 'action' => 'getnothing', 'username'=>'gufron','password'=>md5('jago4n123'),'responsetype'=>'json' ])
          ->andRespondWithJson([ 'result'=>'error','message'=>"Command not found" ], $statusCode = 200);
      $httpMock = new HttpMock();
      $httpMock->attachToClient($client);
      $httpMock
          ->shouldReceiveRequest()
          ->withUrl('http://undefined/hello')
          ->withMethod('POST')
          ->withBodyParams([ 'action' => 'getnothing', 'username'=>'gufron','password'=>md5('jago4n123'),'responsetype'=>'json' ])
          ->andRespondWithJson([ 'result'=>'error','message'=>"Invalid IP Address: 127.0.0.2" ], $statusCode = 200);
    });
  }
  public function testCallApi()
  {
    $whmcs = $this->whmcs;
    $response = $whmcs->getclients();
    // print_r($response);
    $this->assertEquals(true, $response->isSuccess());
    $this->assertArrayHasKey('clients', $response);
    $this->assertEquals([], $response['clients']['client']);
  }

  /**
  * @expectedException \Gufy\WhmcsPhp\Exceptions\ResponseException
  */
  public function testCallback()
  {
    $whmcs = $this->whmcs;
    $this->config->setBaseUrl('http://undefined/hello');
    $whmcs->setBeforeExecute(function(Client &$client){
      $client->setDefaultOption('config', [
        'curl'=>[
          CURLOPT_INTERFACE=>'127.0.0.2',
        ]
      ]);
    });
    // $this->config->setBaseUrl('http://undefined/hello');
    $response = $whmcs->getclients();
    $whmcs->clearCallbacks();
    // print_r($response);
  }
  /**
  * @expectedException \Gufy\WhmcsPhp\Exceptions\ResponseException
  */
  public function testClientException()
  {
    $whmcs = $this->whmcs;
    // $this->config->setBaseUrl('http://undefined/hello');
    $response = $whmcs->getnothing();
    // print_r($response);
  }
  /**
  * @expectedException \Gufy\WhmcsPhp\Exceptions\ReadOnlyException
  */
  public function testRespondedData()
  {
    $whmcs = $this->whmcs;
    $response = $whmcs->getclients();
    $response['clients'] = 'helloworld';
  }
  /**
  * @expectedException \Gufy\WhmcsPhp\Exceptions\ReadOnlyException
  */
  public function testRespondedData2()
  {
    $whmcs = $this->whmcs;
    $response = $whmcs->getclients();
    $this->assertTrue(isset($response['clients']));
    unset($response['clients']);
  }
}
