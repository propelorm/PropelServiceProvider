<?php

/**
 * This file is part of the PropelServiceProvider package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Propel\Silex;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Propel service provider.
 *
 * @author Cristiano Cinotti <cristianocinotti@gmail.com>
 */
class PropelServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
    }

    public function boot(Application $app)
    {
        if (!class_exists('Propel')) {
            require_once $this->guessPropel($app);
        }

        $modelPath = $this->guessModelPath($app);
        $config    = $this->guessConfigFile($app);

        \Propel::init($config);
        set_include_path($modelPath . PATH_SEPARATOR . get_include_path());
    }

    protected  function guessPropel(Application $app)
    {
        if (isset($app['propel.path'])) {
            $propel = $app['propel.path'] . '/Propel.php';
        } else {
            if (!is_file($propel = realpath('./vendor/propel/propel1/runtime/lib/Propel.php'))) {
                $propel = realpath('./../vendor/propel/propel1/runtime/lib/Propel.php');
            }
        }

        if (!is_file($propel)) {
            throw new \InvalidArgumentException('Unable to find Propel, did you set the "propel.path" parameter?');
        }

        return $propel;
    }

    protected function guessModelPath(Application $app)
    {
        if (isset($app['propel.model_path'])) {
            $modelPath = $app['propel.model_path'];
        } else {
            $modelPath = './build/classes';
        }

        if (!is_dir($modelPath)) {
            throw new \InvalidArgumentException('The given "propel.model_path" is not found.');
        }

        return $modelPath;
    }

    protected function guessConfigFile(Application $app)
    {
        if (isset($app['propel.config_file'])) {
            $config = $app['propel.config_file'];
        } else {
            $currentDir = getcwd();
            if (!@chdir(realpath('./build/conf'))) {
                throw new \InvalidArgumentException(
                    'Unable to guess the config file. Please, initialize the "propel.config_file" parameter.'
                );
            }

            $files = glob('classmap*.php');
            if (false === $files || 0 >= count($files)) {
                throw new \InvalidArgumentException(
                    'Unable to guess the config file. Please, initialize the "propel.config_file" parameter.'
                );
            }

            $config = './build/conf/'.substr(strstr($files[0], '-'), 1);
            chdir($currentDir);
        }

        if (!is_file($config)) {
            throw new \InvalidArgumentException(
                'Unable to guess the config file. Please, initialize the "propel.config_file" parameter.'
            );
        }

        return $config;
    }
}
