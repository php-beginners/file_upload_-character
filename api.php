<?php
//	...
$json = [];
$json['status'] = true;
$json['errors'] = [];
$json['result'] = null;
$json['develop'] = [
	'GET '    => $_GET,
	'POST'    => $_POST,
	'FILES'   => $_FILES,
	'IP_ADDR' => $_SERVER['REMOTE_ADDR'],
];

//	...
switch( $_SERVER['REMOTE_ADDR'] ){
	case '::1':
	case '127.0.0.1':
		break;
	default:
		unset($json['develop']);
	break;
}

//	...
$request = (function(){
	$request = null;
	switch( $_SERVER['REQUEST_METHOD'] ){
		case 'GET':
			$request = $_GET;
			break;
		case 'POST':
			$request = $_POST;
			break;
	}
	return $request;
})();

//	...
$file_name = 'uploaded.txt';

//	...
if( $request['content'] ?? null ){
	file_put_contents($file_name, $request['content'], FILE_APPEND | LOCK_EX);
}

//	...
if( file_exists($file_name) ){
	$json['result']['size'] = filesize($file_name);
}

//	...
if( $_GET['html'] ?? null ){
	var_dump($json);
}else{
	echo json_encode($json);
}
