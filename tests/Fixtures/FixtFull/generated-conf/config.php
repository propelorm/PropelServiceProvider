<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->setAdapterClass('bookstore', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'classname' => '\\Propel\\Runtime\\Connection\\DebugPDO',
  'dsn' => 'mysql:host=127.0.0.1;dbname=test',
  'user' => 'test_user',
  'password' => 'test_pwd',
  'options' =>
  array (
    'ATTR_PERSISTENT' => false,
  ),
  'attributes' =>
  array (
    'ATTR_EMULATE_PREPARES' => true,
  ),
  'settings' =>
  array (
    'charset' => 'utf8',
  ),
));
$manager->setName('bookstore');
$serviceContainer->setConnectionManager('bookstore', $manager);
$serviceContainer->setAdapterClass('bookstore-cms', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'classname' => '\\Propel\\Runtime\\Connection\\DebugPDO',
  'dsn' => 'mysql:host=127.0.0.1;dbname=test',
  'user' => 'test_user',
  'password' => 'test_pwd',
  'options' =>
  array (
    'ATTR_PERSISTENT' => false,
  ),
  'attributes' =>
  array (
    'ATTR_EMULATE_PREPARES' => true,
  ),
  'settings' =>
  array (
    'charset' => 'utf8',
  ),
));
$manager->setName('bookstore-cms');
$serviceContainer->setConnectionManager('bookstore-cms', $manager);
$serviceContainer->setAdapterClass('bookstore-behavior', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'classname' => '\\Propel\\Runtime\\Connection\\DebugPDO',
  'dsn' => 'mysql:host=127.0.0.1;dbname=test',
  'user' => 'test_user',
  'password' => 'test_pwd',
  'options' =>
  array (
    'ATTR_PERSISTENT' => false,
  ),
  'attributes' =>
  array (
    'ATTR_EMULATE_PREPARES' => true,
  ),
  'settings' =>
  array (
    'charset' => 'utf8',
  ),
));
$manager->setName('bookstore-behavior');
$serviceContainer->setConnectionManager('bookstore-behavior', $manager);
$serviceContainer->setDefaultDatasource('bookstore');