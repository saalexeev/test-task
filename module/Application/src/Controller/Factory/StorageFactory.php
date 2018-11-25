<?php
/**
 * Created by PhpStorm.
 * User: Stanislav
 * Date: 25.11.2018
 * Time: 02:42
 */

namespace Application\Controller\Factory;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Cache\Storage\Adapter\Filesystem;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Cache\StorageFactory as cache;

class StorageFactory implements FactoryInterface {

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke (ContainerInterface $container, $requestedName, array $options = null) {
        $config = $container->get('Config');

        return cache::factory([
            'adapter' => [
                'name'    => Filesystem::class,
                'options' => [
                    'ttl' => $config['cache_ttl'] ?? 60*60,
                    'cache_dir' => './data/cache',
                    'dir_permission' => 511,
                    'file_permission' => 432,
                ],
            ],
            'plugins' => [
                'exception_handler' => ['throw_exceptions' => true],
            ],
        ]);
    }
}