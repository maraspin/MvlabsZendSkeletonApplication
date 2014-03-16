<?php

/**
 * MV Labs ZF2 Skeleton application error handler
 *
 * @copyright Copyright (c) 2010-2014 MV Labs (http://www.mvlabs.it)
 * @link      http://github.com/mvlabs/MvlabsZendSkeletonApplication
 * @license   Please view the LICENSE file that was distributed with this source code
 * @author    Steve Maraspin <steve@mvlabs.it>
 * @package   MvlabsZendSkeletonApplication
 */

namespace Application;

class ErrorHandler {

    /**
     * Turns PHP errors into exceptions
     *
     * @param integer $i_type
     * @param string $s_message
     * @param string $s_file
     * @param integer $i_line
     * @throws Exception
     */
    public static function handlePhpErrors($i_type, $s_message, $s_file, $i_line) {

    	// Unhandled error case
    	if (!($i_type & error_reporting())) { return; }

    	throw new Exception(self::getErrorType($i_type) . ": " . $s_message .
    			            " in file " . $s_file . " at line " . $i_line);
    }


    /**
     * Redirects user to nice page after fatal has occurred
     *
     * @param string $s_redirectUrl URL where user is directed to after a fatal has occurred
     * @param string $s_callback callback function to be called - IE for specific mailing/logging purposes
     */
    public static function handleFatalPhpErrors($s_redirectUrl, $s_callback = null) {

    	if (php_sapi_name() != 'cli' && @is_array($e = @error_get_last())) {

    		if (null != $s_callback) {
    			// This is the most stuff we can get. All of this happens in
    			// a "new context" outside of framework
    			$s_errorType = isset($e['type']) ? self::getErrorType($e['type']) : 'Error';
    			$s_msg = isset($e['message']) ? $e['message'] : '';
    			$s_file = isset($e['file']) ? $e['file'] : '';
    			$i_line = isset($e['line']) ? $e['line'] : '';
    			$s_callback($s_msg, $s_file, $i_line, $s_errorType);
    		}

    		header("location: ". $s_redirectUrl);

    	}

    	return false;

    }


    private static function getErrorType($i_type) {

    	$s_errorTypeName = 'Error';

    	switch ($i_type) {
    		case E_DEPRECATED:
    			$s_errorTypeName = 'Deprecated';
    		case E_WARNING:
    			$s_errorTypeName = 'Warning';
    		case E_NOTICE:
    			$s_errorTypeName = 'Notice';
    	}

    	return $s_errorTypeName;

    }

}
