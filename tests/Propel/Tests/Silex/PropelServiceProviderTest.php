<?php

/**
 * This file is part of the PropelServiceProvider package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Propel\Tests\Silex;

use Propel\Silex\PropelServiceProvider;
use Silex\Application;

/**
 * PropelProvider test cases.
 *
 * Cristiano Cinotti <cristianocinotti@gmail.com>
 */
class PropelServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!class_exists('\Propel')) {
            $this->markTestSkipped('Propel has to be installed.');
        }
    }

    public function testRegisterWithProperties()
    {
        $app = new Application();
        $app->register(new PropelServiceProvider(), array(
            'propel.path'           => __DIR__ . '/../../../../vendor/propel/propel1/runtime/lib',
            'propel.config_file'    => __DIR__ . '/PropelFixtures/FixtFull/build/conf/myproject-conf.php',
            'propel.model_path'     => __DIR__ . '/PropelFixtures/FixtFull/build/classes',
        ));

        $this->assertTrue(class_exists('Propel'), 'Propel class does not exist.');
        $this->assertGreaterThan(strpos(get_include_path(), $app['propel.model_path']), 1);
    }

    public function testRegisterDefaults()
    {
        $current = getcwd();
        chdir(__DIR__.'/PropelFixtures/FixtFull');

        $app = new Application();
        $app->register(new PropelServiceProvider(), array(
            'propel.path'           => __DIR__ . '/../../../../vendor/propel/propel1/runtime/lib',
        ));

        $this->assertTrue(class_exists('Propel'), 'Propel class does not exist.');
        $this->assertGreaterThan(strpos(get_include_path(), './build/classes'), 1);

        chdir($current);
    }

    /**
     * @expectedException  InvalidArgumentException
     * @expectedExceptionMessage  Unable to guess the config file. Please, initialize the "propel.config_file" parameter.
     */
    public function testConfigFilePropertyNotInitialized()
    {
        $app = new Application();
        $app->register(new PropelServiceProvider(), array(
            'propel.path'               => __DIR__.'/../../../../vendor/propel/propel1/runtime/lib',
            'propel.model_path'         => __DIR__.'/PropelFixtures/FixtFull/build/classes',
        ));
        $app->boot();
    }

    /**
     * @expectedException  InvalidArgumentException
     * @expectedExceptionMessage  The given "propel.model_path" is not found.
     */
    public function testWrongModelPath()
    {
        $app = new Application();
        $app->register(new PropelServiceProvider(), array(
            'propel.path'           => __DIR__ . '/../../../../vendor/propel/propel1/runtime/lib',
            'propel.config_file'    => __DIR__ . '/PropelFixtures/FixtFull/build/conf/myproject-conf.php',
            'propel.model_path'     => __DIR__ . '/wrongDir/build/classes',
        ));
        $app->boot();
    }

    public function testWrongConfigFile()
    {
        $current = getcwd();
        chdir(__DIR__.'/PropelFixtures/FixtEmpty');
        $app = new Application();
        $app->register(new PropelServiceProvider(), array(
            'propel.path'               => __DIR__.'/../../../../vendor/propel/propel1/runtime/lib',
            'propel.model_path'         => __DIR__.'/PropelFixtures/FixtFull/build/classes',
        ));

        try {
            $app->boot();
            $this->fail('An expected InvalidArgumentException has not been raised');
        } catch(\InvalidArgumentException $e) {
            $this->assertTrue(true);
        }

        chdir($current);
    }
}
