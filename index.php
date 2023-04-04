<?php session_start();
require_once './vendor/autoload.php';

class n138 {
	private $exit_params;
	function __constractor(){
		$exit_params = [
			'time' => time(),
			'text' => '',
			'code' => 0,
			'remote' => [
				'address' => '',
			],
		];
	}
	function getExitStatus() {
		$this->setVal('http', http_response_code());
		return $this->exit_params;
	}
	function getVal($key) {
		return $this->exit_params[$key];
	}
	function setVal($key, $val) {
		$this->exit_params[$key] = $val;
	}
}
ini_set('upload_max_filesize', '25M');
header('Content-Type: text/plain');
$exitStatus = new n138();
$exitStatus->setVal('time', time());
$exitStatus->setVal('remote', ['address'=>$_SERVER['REMOTE_ADDR']]);
$exitStatus->setVal('debug', (bool)($_SERVER['HTTP_X_SCRIPT_DEBUG']));

if( mb_strtolower($_SERVER['REQUEST_METHOD']) != 'post' ){
	http_response_code(405);
	$exitStatus->setVal('time', time());
	$exitStatus->setVal('text', 'Method Not Allowed.');
	if ( (bool)($_SERVER['HTTP_X_SCRIPT_DEBUG']) ) {
		$exitStatus->setVal('text', $exitStatus->getVal('text') . '#' . __LINE__);
	}
	
	echo json_encode($exitStatus->getExitStatus(), JSON_PRETTY_PRINT);
	error_log(json_encode($exitStatus->getExitStatus()));
	exit();
}

if ( !isset($_POST) || !is_array($_POST) ) {
	http_response_code(400);
	$exitStatus->setVal('time', time());
	$exitStatus->setVal('text', 'Bad Request.');
	if ( (bool)($_SERVER['HTTP_X_SCRIPT_DEBUG']) ) {
		$exitStatus->setVal('text', $exitStatus->getVal('text') . '#' . __LINE__);
	}
	
	echo json_encode($exitStatus->getExitStatus(), JSON_PRETTY_PRINT);
	error_log(json_encode($exitStatus->getExitStatus()));
	exit();
}

if ( !isset($_FILES['image']) ) {
	http_response_code(400);
	$exitStatus->setVal('time', time());
	$exitStatus->setVal('text', 'Bad Request.');
	if ( (bool)($_SERVER['HTTP_X_SCRIPT_DEBUG']) ) {
		$exitStatus->setVal('text', $exitStatus->getVal('text') . '#' . __LINE__);
	}
	
	echo json_encode($exitStatus->getExitStatus(), JSON_PRETTY_PRINT);
	error_log(json_encode($exitStatus->getExitStatus()));
	exit();
}

if ( !isset($_FILES['image']['error']) || $_FILES['image']['error'] != 0 ) {
	http_response_code(500);
	$exitStatus->setVal('time', time());
	switch ($_FILES['image']['error']) {
		case UPLOAD_ERR_OK:
			break;
		case UPLOAD_ERR_INI_SIZE:
			$exitStatus->setVal('text', 'UPLOAD_ERR_INI_SIZE');
			break;
		case UPLOAD_ERR_FORM_SIZE:
			$exitStatus->setVal('text', 'UPLOAD_ERR_FORM_SIZE');
			break;
		case UPLOAD_ERR_PARTIAL:
			$exitStatus->setVal('text', 'UPLOAD_ERR_PARTIAL');
			break;
		case UPLOAD_ERR_NO_FILE:
			$exitStatus->setVal('text', 'UPLOAD_ERR_NO_FILE');
			break;
		case UPLOAD_ERR_NO_TMP_DIR:
			$exitStatus->setVal('text', 'UPLOAD_ERR_NO_TMP_DIR');
			break;
		case UPLOAD_ERR_CANT_WRITE:
			$exitStatus->setVal('text', 'UPLOAD_ERR_CANT_WRITE');
			break;
		case UPLOAD_ERR_EXTENSION:
			$exitStatus->setVal('text', 'UPLOAD_ERR_EXTENSION');
			break;
		default:
			$exitStatus->setVal('text', 'File error.');
			break;
	}
	$exitStatus->setVal('text', $exitStatus->getVal('text') . ' ');
	$exitStatus->setVal('text', $exitStatus->getVal('text') . 'Error-code: ' . $_FILES['image']['error']);
	if ( (bool)($_SERVER['HTTP_X_SCRIPT_DEBUG']) ) {
		$exitStatus->setVal('text', $exitStatus->getVal('text') . '#' . __LINE__);
	}
	
	echo json_encode($exitStatus->getExitStatus(), JSON_PRETTY_PRINT);
	error_log(json_encode($exitStatus->getExitStatus()));
	exit();
}

if ( !isset($_FILES['image']['error']) || $_FILES['image']['size'] == 0 ) {
	http_response_code(500);
	$exitStatus->setVal('time', time());
	$exitStatus->setVal('text', 'File error');
	if ( (bool)($_SERVER['HTTP_X_SCRIPT_DEBUG']) ) {
		$exitStatus->setVal('text', $exitStatus->getVal('text') . '#' . __LINE__);
	}
	
	echo json_encode($exitStatus->getExitStatus(), JSON_PRETTY_PRINT);
	error_log(json_encode($exitStatus->getExitStatus()));
	exit();
}

if ( !file_exists($_FILES['image']['tmp_name']) ) {
	http_response_code(500);
	$exitStatus->setVal('time', time());
	$exitStatus->setVal('text', 'Bad Request.');
	if ( (bool)($_SERVER['HTTP_X_SCRIPT_DEBUG']) ) {
		$exitStatus->setVal('text', $exitStatus->getVal('text') . '#' . __LINE__);
	}
	
	echo json_encode($exitStatus->getExitStatus(), JSON_PRETTY_PRINT);
	error_log(json_encode($exitStatus->getExitStatus()));
	exit();
}

try {
	list($image['size']['w'], $image['size']['h']) = getimagesize($_FILES['image']['tmp_name']);
	var_dump($image);

} catch (Exception $e) {
	var_dump($e);
}
echo json_encode([$_POST, $_FILES], JSON_PRETTY_PRINT);
