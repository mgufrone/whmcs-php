<?php
use Gufy\WhmcsPhp\Config;
use Gufy\WhmcsPhp\Whmcs;
use Gufy\WhmcsPhp\WhmcsResponse;
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
  }
  public function testCallApi()
  {
    $whmcs = $this->whmcs;
    $response = $whmcs->getclients();
    $this->assertEquals(true, $response->isSuccess());
    $this->assertArrayHasKey('clients', $response);
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
  * @expectedException \Gufy\WhmcsPhp\Exceptions\ResponseException
  * @expectedMessage Invalid IP Address : 127.0.0.3
  */
  public function testCallback()
  {
    $whmcs = $this->whmcs;
    $whmcs->setBeforeExecute(function(Client &$client){
      $client->setDefaultOption('config', [
        'curl'=>[
          CURLOPT_INTERFACE=>'127.0.0.2',
        ]
      ]);
    });
    // $this->config->setBaseUrl('http://undefined/hello');
    $response = $whmcs->getclients();
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
