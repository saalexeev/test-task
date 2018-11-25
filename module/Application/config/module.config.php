<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\TaskController;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Cache\Storage\StorageInterface;
use Zend\Mvc\Controller\LazyControllerAbstractFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'index' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'api' => [
                'type' => Literal::class,
                'child_routes' => [
                    'v1' => [
                        'type' => Literal::class,
                        'child_routes' => [
                            'tasks' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/task',
                                    'defaults' => [
                                        'controller' => TaskController::class,
                                        'action' => 'index'
                                    ]
                                ],
                            ],
                            'task' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/task/:id',
                                    'defaults' => [
                                        'controller' => TaskController::class,
                                        'action' => 'edit'
                                    ]
                                ]
                            ]
                        ],
                        'options' => [
                            'route' => '/v1'
                        ]
                    ]
                ],
                'options' => [
                    'route' => '/api'
                ]
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => LazyControllerAbstractFactory::class,
            TaskController::class => LazyControllerAbstractFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'error/index'      => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ],
    ],
    'service_manager' => [
        'factories' => [
            StorageInterface::class => \Application\Controller\Factory\StorageFactory::class
        ],
    ]
];
