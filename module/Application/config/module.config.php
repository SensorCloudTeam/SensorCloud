<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'application' => array(
            		'type'    => 'segment',
            		'options' => array(
            				'route'    => '/application[/:action]',
            				'constraints' => array(
            						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            				),
            				'defaults' => array(
            						'controller' => 'Application\Controller\Index',
            						'action'     => 'index',
            				),
            		),
            ),
            'poster' => array(
            		'type'    => 'segment',
            		'options' => array(
            				'route'    => '/poster[/:action][/:sink_id][/:sensor_id]',
            				'constraints' => array(
            						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            						'sink_id'     => '[a-zA-z0-9]*',
            						'sensor_id'     => '[a-zA-z0-9]*',
            				),
            				'defaults' => array(
            						'controller' => 'Application\Controller\Poster',
            						'action'     => 'poster',
            				),
            		),
            ),
            'subscriber' => array(
            		'type'    => 'segment',
            		'options' => array(
            				'route'    => '/subscriber[/:action][/:sink_id][/:subscription_id]',
            				'constraints' => array(
            						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            						'sink_id'     => '[a-zA-z0-9]*',
            						'subscription_id'     => '[a-zA-z0-9]*',
            				),
            				'defaults' => array(
            						'controller' => 'Application\Controller\Subscriber',
            						'action'     => 'subscriber',
            				),
            		),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index'  => 'Application\Controller\IndexController',
            'Application\Controller\Poster' => 'Application\Controller\PosterController',
            'Application\Controller\Subscriber' => 'Application\Controller\SubscriberController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/application/index.phtml',
            'application/index/register' => __DIR__ . '/../view/application/application/register.phtml',
            'application/index/login' => __DIR__ . '/../view/application/application/login.phtml', 
            'application/index/logout' => __DIR__ . '/../view/application/application/index.phtml',
            'application/index/usercenter' => __DIR__ . '/../view/application/application/usercenter.phtml',
            'application/index/userframe' => __DIR__ . '/../view/application/application/userframe.phtml',
            'application/index/userguide' => __DIR__ . '/../view/application/application/userguide.phtml',
            'application/index/mycenter' => __DIR__ . '/../view/application/application/mycenter.phtml',
            'application/index/userinfo' => __DIR__ . '/../view/application/application/userinfo.phtml',
            'application/index/changepass' => __DIR__ . '/../view/application/application/changepass.phtml',
            'application/poster/mysink' => __DIR__ . '/../view/application/poster/mysink.phtml',
            'application/poster/addsink' => __DIR__ . '/../view/application/poster/addsink.phtml',
            'application/poster/mysensor' => __DIR__ . '/../view/application/poster/mysensor.phtml',
            'application/poster/addsensor' => __DIR__ . '/../view/application/poster/addsensor.phtml',
            'application/subscriber/subscriberindex' => __DIR__ . '/../view/application/subscriber/subscriberindex.phtml',
            'application/subscriber/sinkinfo' => __DIR__ . '/../view/application/subscriber/sinkinfo.phtml',
            'application/subscriber/mysubscription' => __DIR__ . '/../view/application/subscriber/mysubscription.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            'application' => __DIR__ . '/../view',
        ),
    ),
);
