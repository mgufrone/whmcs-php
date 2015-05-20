<?php
use Gufy\WhmcsPhp\Config;
class ConfigTest extends PHPUnit_Framework_TestCase
{
  public function testInitializeConfiguration()
  {
    $config = new Config([
      'baseUrl'=>'http://localhost/includes/api.php',
      'username'=>'gufron',
      'password'=>'helloworld',
      'authType'=>'password',
      // 'response'=>'object',
      // 'responsetype'=>'json'
    ]);
    $this->assertEquals('http://localhost/includes/api.php', $config->getBaseUrl());
    $this->assertEquals('gufron', $config->getUsername());
    $this->assertEquals('password', $config->getAuthType());
    $this->assertEquals(md5('helloworld'), $config->getPassword());
    $this->assertEquals('object', $config->getResponse());
    $this->assertEquals('json', $config->getResponseType());
  }

  public function testChangeConfiguration()
  {
    $config = new Config([
      'baseUrl'=>'http://localhost/includes/api.php',
      'username'=>'gufron',
      'password'=>'helloworld',
      'authType'=>'password',
      // 'response'=>'object',
      // 'responsetype'=>'json'
    ]);
    $this->assertEquals('http://localhost/includes/api.php', $config->getBaseUrl());
    $config->setBaseUrl('http://localhost/whmcs/includes/api.php');
    $this->assertEquals('http://localhost/whmcs/includes/api.php', $config->getBaseUrl());

    $this->assertEquals('gufron', $config->getUsername());
    $config->setUsername('gufy');
    $this->assertEquals('gufy', $config->getUsername());

    $this->assertEquals('password', $config->getAuthType());
    $config->setAuthType('keys');
    $this->assertEquals('keys', $config->getAuthType());

    $this->assertEquals('object', $config->getResponse());
    $config->setResponse('array');
    $this->assertEquals('array', $config->getResponse());

    $this->assertEquals('json', $config->getResponseType());
    $config->setResponseType('xml');
    $this->assertEquals('xml', $config->getResponseType());

    $this->assertEquals(md5('helloworld'), $config->getPassword());
    $config->setPassword('awesomeworld');
    $this->assertEquals(md5('awesomeworld'), $config->getPassword());

  }

  // public function
}
