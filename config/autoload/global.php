<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(

		'mvlabs_environment_config' => array(

			// Set this w/ the timezone of your running application
			'timezone' => 'Europe/London',

			// PHP ini settings
			'php_settings' => array(
				'error_reporting'  =>  (E_ALL ^ E_NOTICE),
				'display_errors' => 'Off',
				'display_startup_errors' => 'Off',
			),

			'exceptions_from_errors' => true,
			'recover_from_fatal' => true,
			'fatal_errors_callback' => function($s_msg, $s_file, $s_line) {

				return false;

			},
		),

		'service_manager' => array(
				'abstract_factories' => array(
						'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
						'Zend\Log\LoggerAbstractServiceFactory',
				),
		),

);
