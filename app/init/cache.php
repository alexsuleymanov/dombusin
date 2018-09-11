<?
	$frontendOptions = array(
		'lifetime' => 86400*30,
		'automatic_serialization' => true
	); 
	$backendOptions = array(
    	'cache_dir' => $path."/tmp/",
	);
 
	$cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);

	$frontendOptions = array(
		'lifetime' => 86400*30,
		'automatic_serialization' => true
	);
	$backendOptions = array(
    	'cache_dir' => $path."/tmp/img/",
	);

	$outputcache = Zend_Cache::factory('Output', 'File', $frontendOptions, $backendOptions);

/*	$frontendOptions = array(
		'lifetime' => 86400,
		'automatic_serialization' => true
	);

	$memcache = Zend_Cache::factory('Core', 'Memcached', $frontendOptions, $backendOptions);
*/	
	define("CACHE_ON", 1);