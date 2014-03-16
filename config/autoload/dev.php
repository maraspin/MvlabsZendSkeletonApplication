<?php

/**
 * Development configuration - overrides global.php configuration values
 *
 * You can use this file for overriding configuration values from modules
 * and global values. You would place values in here that are environment
 * specifict and not sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(

		/*
		 Specific development environment routes can be defined herein
		 'router' => array(
		 		'routes' => array(
		 				'admin' => array(
		 						'options' => array(
		 								'route'  => 'www.dev.mydomain.it',
		 						),
		 				),
		 		),
		 ),
		*/

		'mvlabs_environment_config' => array(

				'php_settings' => array(
						'error_reporting'  =>  E_ALL,
						'display_errors' => 'On',
						'display_startup_errors' => 'On',
				),

				'exceptions_from_errors' => true,
				'recover_from_fatal' => false,
				'show_environment' => true,

				// here you should set the hostname of your development host(s)
				// dev configuration will be allowed to run here only!
				'allowed_hosts' => array('dev', 'my.development.host', 'my-collegue.development.host')

		),

		// View manager is set with debugging
		'view_manager' => array(
				'display_not_found_reason' => true,
				'display_exceptions'       => true,
				'template_map' => array(
						// We want a page showing us full exception stack trace
						'error/index'             => __DIR__ . '/../../module/Application/view/error/debug.phtml',
				),
		),

		// Developer Tools Configuration
		'zenddevelopertools' => array(
				'profiler' => array(
						'enabled' => true,
						'strict' => false,
				),
				'toolbar' => array(
						 'enabled' => true,
						'auto_hide' => false,
						'position' => 'bottom',
						'version_check' => true,
				),
		),

);
