<?php

/**
 * MV Labs ZF2 Skeleton application environment configuration helper
 *
 * @copyright Copyright (c) 2010-2014 MV Labs (http://www.mvlabs.it)
 * @link      http://github.com/mvlabs/MvlabsZendSkeletonApplication
 * @license   Please view the LICENSE file that was distributed with this source code
 * @author    Steve Maraspin <steve@mvlabs.it>
 * @package   MvlabsZendSkeletonApplication
 */

namespace Application;

class Environment {


	/**
	 * Environment name
	 *
	 * @var string
	 */
	private $s_environmentName = null;


	/**
	 * Application configuration
	 *
	 * @var array
	 */
	private $am_appConfig = array();


	/**
	 *  Environment constructor
	 *
	 * @param string Environment Namee
	 */
	public function __construct($s_environmentName, $am_appConfig) {

		$this->s_environmentName = $s_environmentName;

		// Checks whether selected environment can be run within current host
		$this->validateEnv($am_appConfig);

		$this->am_appConfig = $am_appConfig;

	}


    /**
     * Takes care of enabling environment configuration parameters
     *
     * @param array $am_config application configuration
     */
    public function load() {

    	// No conf is loaded in this case
    	if(!array_key_exists('mvlabs_environment_config', $this->am_appConfig)) {
    		return;
    	}

    	$am_environmentConf = $this->am_appConfig['mvlabs_environment_config'];

    	// Timezone is set
    	$s_timeZone = (array_key_exists('timezone', $am_environmentConf)?$am_environmentConf['timezone']:'Europe/London');
    	date_default_timezone_set($s_timeZone);


    	if (array_key_exists('php_settings', $am_environmentConf) &&
    	is_array($am_environmentConf['php_settings'])) {
    		// PHP Settings are Set
    		$this->setPhpEnvVars($am_environmentConf['php_settings']);
    	}


    	// Dealing with PHP errors
    	if (array_key_exists('exceptions_from_errors', $am_environmentConf) &&
    	    $am_environmentConf['exceptions_from_errors']) {
    		// PHP errors gets turned into exceptions
    		set_error_handler(array('Application\ErrorHandler','handlePhpErrors'));
    	}


    	// Dealing with fatal errors
    	if (array_key_exists('recover_from_fatal', $am_environmentConf) &&
    	    $am_environmentConf['recover_from_fatal']) {

    		// @TODO: I'm quite sure there's a better way to obtain this...
    		$s_redirectUrl = $am_config['router']['routes']['error']['options']['route'];

    		$s_callback = null;
    		if (array_key_exists('fatal_errors_callback', $am_environmentConf)) {
    			$s_callback = $am_environmentConf['fatal_errors_callback'];
    		}

    		// Recovering from fatals attempt is done.
    		register_shutdown_function(array('Application\ErrorHandler', 'handleFatalPhpErrors'),
    		                           $s_callback, $s_logFile, $s_emailRecipient, $s_redirectUrl);
    	}

    }


    /**
     * Checks whether application can run on current host w/ current env settings
     *
     * @param string $s_currentEnvironment
     * @param array $am_appConf application configuration
     * @return boolean
     */
    private function validateEnv($am_appConfig) {

    	if (!array_key_exists('allowed_hosts', $am_appConfig['mvlabs_environment_config'])) {
    		return;
    	}

    	if (!is_array($am_appConfig['mvlabs_environment_config']['allowed_hosts'])) {
    		throw new Exception('Invalid allowed hosts configuration.
    				Please make sure allowed_hosts param on file ' .
    				$this->s_environmentName . '.php is an array (currently: ' .
    				gettype($am_appConfig['mvlabs_environment_config']['allowed_hosts']).')');
    	}

    	if (count($am_appConfig['mvlabs_environment_config']['allowed_hosts']) == 0
    	) {
    		// No checks are enforced, no need to proceed
    		return;
    	}

    	$s_hostName = gethostname();

    	if (!in_array($s_hostName, $am_appConfig['mvlabs_environment_config']['allowed_hosts'])) {
    		throw new Exception('Application is not supposed to run with ' . $this->s_environmentName .
    				' configuration on host ' . $s_hostName.
    				'. Did you remember to set allowed_hosts param on file ' .
    				$this->s_environmentName.'.php? '
    		);
    	}

    }


	/**
	 * Sets php environment variables
	 *
	 * @param array $am_phpSettings php specific settings
	 */
    private function setPhpEnvVars(array $am_phpSettings) {
    	foreach($am_phpSettings as $key => $value) {
    		ini_set($key, $value);
    	}
    }


}
