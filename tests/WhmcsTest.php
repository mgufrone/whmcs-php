<?php
use Gufy\WhmcsPhp\Config;
use Gufy\WhmcsPhp\Whmcs;
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
    $response = $this->whmcs->getclients();
    $this->assertEquals(true, $response->isSuccess());
    $this->assertArrayHasKey('clients', $response);
  }
}
