<?php
/**
 * This file is part of the PropelServiceProvider package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Propel\Silex;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Propel\Runtime\Propel as Propel2;

use Silex\Api\BootableProviderInterface;
use Silex\Application;

 /**
  * Propel2 service provider.
  *
  * @author Cristiano Cinotti <cristianocinotti@gmail.com>
  * @author Rafael Nery <rafael@nery.info>
  */
class Propel implements ServiceProviderInterface, BootableProviderInterface
{

    /**
     *  Method for register
     *
     *  @method  register
     *  @param   Container  $app
     *  @return  void
     */
    public function register(Container $app)
    {

        if (!class_exists('Propel\\Runtime\\Propel', true)) {
            throw new \InvalidArgumentException('Propel not found, did you install it?');
        }

        $app['propel.config_file'] = './generated-conf/config.php';
    }

    /**
     *  Bootable Method
     *
     *  @method  boot
     *  @param   Application  $app
     *  @return  void
     */
    public function boot(Application $app)  {

        if (!file_exists($app['propel.config_file'])) {
            throw new \InvalidArgumentException('Unable to guess Propel config file. Please, initialize the "propel.config_file" parameter.');
        }

        Propel2::init($app['propel.config_file']);
    }
}
