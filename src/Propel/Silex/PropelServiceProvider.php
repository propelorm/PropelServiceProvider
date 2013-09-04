<?php

/**
 * This file is part of the PropelServiceProvider package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Propel\Silex;

use Propel\Runtime\Propel;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Propel2 service provider.
 *
 * @author Cristiano Cinotti <cristianocinotti@gmail.com>
 */
class PropelServiceProvider implements ServiceProviderInterface
{

    public function register(Application $app)
    {
        if (!class_exists('Propel\\Runtime\\Propel', true)) {
            throw new \InvalidArgumentException('Unable to find Propel, did you install it?');
        }

        $app['propel.config_file'] = './generated-conf/config.php';
    }

    public function boot(Application $app)
    {
        if (!file_exists($app['propel.config_file'])) {
            throw new \InvalidArgumentException('Unable to guess Propel config file. Please, initialize the "propel.config_file" parameter.');
        }

        Propel::init($app['propel.config_file']);
    }
}
