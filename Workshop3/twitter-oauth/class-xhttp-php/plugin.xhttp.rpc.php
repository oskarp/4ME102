<?php

// Arvin Castro
// December 17, 2010
// http://sudocode.net/sources/includes/class-xhttp-php/plugin-xhttp-rpc-php

require_once 'class.xhttp.php';

class xhttp_rpc {

	public function __construct() {
		// oh, nothing
	}

	public function call($url, $method, $parameters, $options = array()) {
		$options = array_merge(array('verbosity'=>'no_white_space'), $options);
        $data['post'] = xmlrpc_encode_request($method, $parameters, $options);
        $data['headers']['Content-Type'] = 'text/xml';
        $data['method'] = 'post';

        xhttp::addHookToRequest($data, 'data-preparation', array(__CLASS__, 'set_rpc_data'), 8);

        $response = xhttp::fetch($url, $data);

        $response['raw'] = $response['body'];
        $response['body'] = str_replace('i8>', 'i4>', $response['body']);
        $response['body'] = xmlrpc_decode($response['body']);

        if($response['body'] AND xmlrpc_is_fault($response['body'])) {
            $response['rpc_fault'] = $response['body']['faultString'];
            $response['rpc_fault_code'] = $response['body']['faultCode'];
        }
        return $response;
	}

	public function load() {
		return true;
	}

	// hook: data-preparation
	public static function set_rpc_data(&$urlparts, &$requestData) {
		$requestData['method'] = 'post';
		$requestData['curl'][CURLOPT_POSTFIELDS] = $requestData['post'];
		$requestData['post'] = null;
	}
}

?>