<?php
namespace ItemRelation;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [    
    'api_adapters' => [
        'invokables' => [
            'item_relations' => Api\Adapter\ItemRelationAdapter::class,
        ],
    ],
    'entity_manager' => [
        'mapping_classes_paths' => [
            dirname(__DIR__) . '/src/Entity',
        ],
        'proxy_paths' => [
            dirname(__DIR__) . '/data/doctrine-proxies',
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'relatedItemsWidget' => Service\ViewHelper\RelatedItemsWidgetFactory::class,
        ],
    ],
    'controllers' => [
        'invokables' => [
            Controller\IndexController::class => Controller\IndexController::class,
        ],
    ],
    'navigation' => [
        'AdminModule' => [
            [
                'label' => 'Item Relations',
                'route' => 'admin/item-relation',
                'resource' => Controller\IndexController::class,
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'admin' => [
                'child_routes' => [
                    'item-relation' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/item-relation',
                            'defaults' => [
                                '__NAMESPACE__' => 'ItemRelation\Controller',
                                'controller' => Controller\IndexController::class,
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'add' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/add',
                                    'defaults' => [
                                        'action' => 'add'
                                    ],
                                ],
                            ],
                            'delete_confirm' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/delete-confirm/:id',
                                    'defaults' => [
                                        'action' => 'deleteConfirm'
                                    ],
                                ],
                            ],
                            'add_item' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/:id/add',
                                    'defaults' => [
                                        'action' => 'addItem',
                                    ],
                                ],
                            ],
                            'delete_item' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/delete-item/:parent/:child',
                                    'defaults' => [
                                        'action' => 'deleteItem',
                                    ],
                                ],
                            ],
                            'delete' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/:id/delete',
                                    'defaults' => [
                                        'action' => 'delete'
                                    ],
                                ],
                            ],
                            'edit' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/:id/edit',
                                    'defaults' => [
                                        'action' => 'edit'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]    
];