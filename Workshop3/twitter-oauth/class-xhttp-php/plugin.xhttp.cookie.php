<?php

# Arvin Castro
# December 17, 2010
# http://sudocode.net/sources/includes/class-xhttp-php/plugin-xhttp-cookie-php/

/*
	07-06-11 Added import and export functions
	17-12-10 Creation date
*/

class xhttp_cookie {

	const IMPORT_REPLACE = 0;
	const IMPORT_ADD = 1;
	const IMPORT_MERGE = 2;

	private static $datastore = array();
	# datastore[profile][domain][path]

	public function __construct() {
		# oh, nothing
	}

	public static function load() {
		xhttp::load('profile');
		xhttp::addHook('data-preparation', array(__CLASS__, 'apply_cookies'), 3);
		xhttp::addHook('return-response',  array(__CLASS__, 'store_cookies'), 8);
		xhttp_profile::addFunction('export_cookies', array(__CLASS__, 'export_cookies'));
		xhttp_profile::addFunction('import_cookies', array(__CLASS__, 'import_cookies'));
		return true;
	}

	public static function clear($name = '*', $website = '*', $directory = '/') {
		if($name == '*' and $website == '*' and $directory == '/') self::$datastore = array();
		else foreach(self::$datastore as $profile => &$domains) if($name == '*' or $profile == $name) {
			if($website == '*' and $directory == '/') self::$datastore[$name] = array();
			else foreach($domains as $domain => &$paths) if($website == '*' or stripos($domain, $website) + strlen($website) == strlen($domain)) {
					if($directory == '/') self::$datastore[$profile][$domain] = array();
					else foreach($paths as $path => &$cookies) if(stripos($path, $directory) === 0) self::$datastore[$profile][$website][$path] = array();
			}
		}
	}

	# hook: data-preparation
	public static function apply_cookies(&$urlparts, &$requestData) {
		$profile = (isset($requestData['profile']['name'])) ? $requestData['profile']['name']: 'default';

		if(isset(self::$datastore[$profile])) foreach(self::$datastore[$profile] as $domain => &$paths) {
			if(stripos($urlparts['host'], $domain) !== false and (stripos($urlparts['host'], $domain) + strlen($domain)) == strlen($urlparts['host'])) foreach($paths as $path => &$cookies) {
				if(stripos($urlparts['path'], $path) == 0
					# and (!isset($cookies['expires']) or  $cookies['expires'] > time())
					# and (!isset($cookies['secure'])  or !$cookies['secure'] or substr($urlparts['scheme'], -1) == 's')
					) {
					$clone = $cookies;
					unset($clone['domain'], $clone['path'], $clone['expires'], $clone['secure'], $clone['max-age']);
					$requestData['cookies'] = (array) $requestData['cookies'] + $clone;
				}
			}
		}
	}

	# hook: return-response
	public static function store_cookies(&$response, &$responseData) {
		$profile = (isset($responseData['request']['profile']['name'])) ? $responseData['request']['profile']['name']: 'default';
		if(isset($responseData['headers']['cookies'])) {
			$domain = $responseData['headers']['cookies']['domain'];
			$path   = $responseData['headers']['cookies']['path'];
			self::$datastore[$profile][$domain][$path] = array_merge((array) self::$datastore[$profile][$domain][$path], $responseData['headers']['cookies']);
		}
	}

	public static function export_cookies($profile = null) {
		$profile = $profile ? $profile: 'default';
		return (array) self::$datastore[$profile];
	}

	public static function import_cookies($profile = null, $cookies, $mode = self::IMPORT_MERGE) {
		$profile = $profile ? $profile: 'default';
		if($mode == self::IMPORT_REPLACE) {
			self::$datastore[$profile] = $cookies;
		} elseif($mode == self::IMPORT_ADD) {
			self::$datastore[$profile] = (array) self::$datastore[$profile] + $cookies;
		} else {
			self::$datastore[$profile] = array_merge((array) self::$datastore[$profile], $cookies);
		}
	}

	public static function export_datastore() {
		return self::$datastore;
	}
}

?>