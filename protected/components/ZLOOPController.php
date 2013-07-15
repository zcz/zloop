<?php

/**
 * base controller for the whole website
 * defined layout and pageTitle
 */

class ZLOOPController extends CController
{
	public $layout='//layouts/column3';
	public $pageTitle = "";
	public $title_forShare = "zloop";
	public $image_forShare = "";
	public $description_forShare = "a website for second-hand goods exchange";
	public $breadcrumbs=array();
	
	public function init() {
		parent::init();
		$this->pageTitle = Yii::app()->name;
	}
	
	public function addToTitle( $s = "") {
		if ($s == null || $s == "") return;
		$this->pageTitle .= " - " . $s;
	}
	
	/* for rest api */
	/**
	 * Send raw HTTP response
	 * @param int $status HTTP status code
	 * @param string $body The body of the HTTP response
	 * @param string $contentType Header content-type
	 * @return HTTP response
	 */
	protected function sendResponse($status = 200, $body = '', $contentType = 'application/json')
	{
		// Set the status
		$statusHeader = 'HTTP/1.1 ' . $status . ' ' . $this->getStatusCodeMessage($status);
		header($statusHeader);
		// Set the content type
		header('Content-type: ' . $contentType);
	
		echo $body;
		Yii::app()->end();
	}
	
	/**
	 * Return the http status message based on integer status code
	 * @param int $status HTTP status code
	 * @return string status message
	 */
	protected function getStatusCodeMessage($status)
	{
		$codes = array(
				100 => 'Continue',
				101 => 'Switching Protocols',
				200 => 'OK',
				201 => 'Created',
				202 => 'Accepted',
				203 => 'Non-Authoritative Information',
				204 => 'No Content',
				205 => 'Reset Content',
				206 => 'Partial Content',
				300 => 'Multiple Choices',
				301 => 'Moved Permanently',
				302 => 'Found',
				303 => 'See Other',
				304 => 'Not Modified',
				305 => 'Use Proxy',
				306 => '(Unused)',
				307 => 'Temporary Redirect',
				400 => 'Bad Request',
				401 => 'Unauthorized',
				402 => 'Payment Required',
				403 => 'Forbidden',
				404 => 'Not Found',
				405 => 'Method Not Allowed',
				406 => 'Not Acceptable',
				407 => 'Proxy Authentication Required',
				408 => 'Request Timeout',
				409 => 'Conflict',
				410 => 'Gone',
				411 => 'Length Required',
				412 => 'Precondition Failed',
				413 => 'Request Entity Too Large',
				414 => 'Request-URI Too Long',
				415 => 'Unsupported Media Type',
				416 => 'Requested Range Not Satisfiable',
				417 => 'Expectation Failed',
				500 => 'Internal Server Error',
				501 => 'Not Implemented',
				502 => 'Bad Gateway',
				503 => 'Service Unavailable',
				504 => 'Gateway Timeout',
				505 => 'HTTP Version Not Supported',
	
		);
		return (isset($codes[$status])) ? $codes[$status] : '';
	}
}
