<?php

/**
 * ZF2 Skeleton application development environment configuration
 *
 * @copyright Copyright (c) 2010-2013 MV Labs (http://www.mvlabs.it)
 * @link      http://github.com/mvlabs/MvlabsZendSkeletonApplication
 * @license   Please view the LICENSE file that was distributed with this source code
 * @author    Steve Maraspin <steve@mvlabs.it>
 * @package   MvlabsZendSkeletonApplication
 */

return array(

		/*
		 Specific production environment routes can be defined herein
		 'router' => array(
		 		'routes' => array(
		 				'admin' => array(
		 						'options' => array(
		 								'route'  => 'admin.mydomain.it',
		 						),
		 				),
		 		),
		 ),
		*/

		'mvlabs_environment_config' => array(

			// hostname of production host(s) - only these will be allowed
			// to run with production configuration
			'allowed_hosts' => array('my.production.host'),

		),

);
