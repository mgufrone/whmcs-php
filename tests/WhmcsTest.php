<?php
use Gufy\WhmcsPhp\Config;
use Gufy\WhmcsPhp\Whmcs;
use Gufy\WhmcsPhp\WhmcsResponse;
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
    $whmcs = Mockery::mock($this->whmcs);
    $whmcs->shouldReceive('__call[$function, $arguments=[]]', array('getclients', []))->andReturn(new WhmcsResponse(['result'=>'success','clients'=>['client'=>[]]]));
    $whmcs->shouldReceive('getclients')->andReturn(new WhmcsResponse(['result'=>'success','clients'=>['client'=>[]]]));
    $response = $whmcs->getclients();
    $this->assertEquals(true, $response->isSuccess());
    $this->assertArrayHasKey('clients', $response);
  }
}
