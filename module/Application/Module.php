<?php

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\Model\UserTable;
use Application\Model\SinkTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'Application\Model\UserTable' =>  function($sm) {
    						$tableGateway = $sm->get('UserTableGateway');
    						$table = new UserTable($tableGateway);
    						return $table;
    					},
    					'UserTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
    					},
    					'Application\Model\SinkTable' =>  function($sm) {
    						$tableGateway = $sm->get('SinkTableGateway');
    						$table = new SinkTable($tableGateway);
    						return $table;
    					},
    					'SinkTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						return new TableGateway('sink', $dbAdapter, null, $resultSetPrototype);
    					},
    					'db_adapter' => function($sm) {
    						$dbAdapter   = $sm->get('Zend\Db\Adapter\Adapter');
    						
    						return $dbAdapter;
    					},
    			),
    	);
    }
}
