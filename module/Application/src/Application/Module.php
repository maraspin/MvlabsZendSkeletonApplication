<?php

/**
 * MV Labs ZF2 Skeleton application module initialization file
 *
 * @copyright Copyright (c) 2010-2013 MV Labs (http://www.mvlabs.it)
 * @link      http://github.com/mvlabs/MvlabsZendSkeletonApplication
 * @license   Please view the LICENSE file that was distributed with this source code
 * @author    Steve Maraspin <steve@mvlabs.it>
 * @package   MvlabsZendSkeletonApplication
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;


class Module {

	/**
	 * Application configuration is returned
	 * @return array Application configuration
	 */
	public function getConfig()
	{
		return include __DIR__ . '/../../config/module.config.php';
	}


	/**
	 * Returns autoloader configuration
	 * @return multitype:multitype:multitype:string
	 */
	public function getAutoloaderConfig()
	{
		return array(
				'Zend\Loader\StandardAutoloader' => array(
						'namespaces' => array(
								__NAMESPACE__ => __DIR__ ,
						),
				),
		);
	}


	/**
	 * Application depends on Lumber logging module for error handling
	 * @return array Needed modules
	 */
	public function getModuleDependencies() {
		return array('MvlabsLumber');
	}


	/**
	 * Called up upon module bootstrap - initializes it
	 * @param MvcEvent $I_e
	 */
	public function onBootstrap(MvcEvent $I_e) {

    	// Application configuration
    	$I_application = $I_e->getParam('application');
    	$am_config = $I_application->getConfig();

    	$am_bootConfig = $I_application->getServiceManager()->get("ApplicationConfig");

    	// Environment name is taken from global configuration - Preserving DRY
    	$s_env = $am_bootConfig['mvlabs_environment_name'];

    	try {

    		// Proper environment configuration gets loaded
    		$I_environment = new Environment($s_env, $am_config);
    		// Environment settings are loaded
    		$I_environment->load();

    	} catch (\Exception $I_exception) {
    		// We make sure proper care is taken for exceptions
    		$I_em = $I_application->getEventManager();
    		$I_e->setParam('exception', $I_exception);
    		$I_e->setParam('error', \Zend\Mvc\Application::ERROR_EXCEPTION);
    		$I_e->setName(MvcEvent::EVENT_DISPATCH_ERROR);
    		$I_em->trigger($I_e);
    	}

        // Environment name is passed to the viewModel
        $I_viewModel = $I_application->getMvcEvent()->getViewModel();
        $I_viewModel->mvlabs_environment_name = $s_env;

	}

}
