<?php

class SimpleLogFilter extends CLogFilter
{
	protected function getContext()
	{
		$context="";
		//		if($this->logUser && ($user=Yii::app()->getComponent('user',false))!==null)
		//		$context='User: '.$user->getName().' (ID: '.$user->getId().')';
		return $context;
	}

	protected function format(&$logs)
	{
		//print_r($logs);
		foreach($logs as &$log)
		{
			$context="";
			if($this->logUser && ($user=Yii::app()->getComponent('user',false))!==null)
			$context='[U:'.$user->getName().'] [ID:'.$user->getId().'] [IP:'.$this->getip().']';
				
			$text = explode( "\n", $log[0]);
			//print_r($text);
			$log[0] = $context." ".$text[0];
		}
		//print_r($logs);
	}


	private function validip($ip) {
		if (!empty($ip) && ip2long($ip)!=-1) {
			$reserved_ips = array (
			array('0.0.0.0','2.255.255.255'),
			array('10.0.0.0','10.255.255.255'),
			array('127.0.0.0','127.255.255.255'),
			array('169.254.0.0','169.254.255.255'),
			array('172.16.0.0','172.31.255.255'),
			array('192.0.2.0','192.0.2.255'),
			array('192.168.0.0','192.168.255.255'),
			array('255.255.255.0','255.255.255.255')
			);

			foreach ($reserved_ips as $r) {
				$min = ip2long($r[0]);
				$max = ip2long($r[1]);
				if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;
			}
			return true;
		} else {
			return false;
		}
	}

	private function getip() {

		if (isset($_SERVER["HTTP_CLIENT_IP"]))
		{
			if ($this->validip($_SERVER["HTTP_CLIENT_IP"])) {
				return $_SERVER["HTTP_CLIENT_IP"];
			}
		}

		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
			foreach (explode(",",$_SERVER["HTTP_X_FORWARDED_FOR"]) as $ip) {
				if ($this->validip(trim($ip))) {
					return $ip;
				}
			}
		}
		
		
		if (isset($_SERVER["HTTP_X_FORWARDED"]) && $this->validip($_SERVER["HTTP_X_FORWARDED"])) {
			return $_SERVER["HTTP_X_FORWARDED"];
		} elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]) && $this->validip($_SERVER["HTTP_FORWARDED_FOR"])) {
			return $_SERVER["HTTP_FORWARDED_FOR"];
		} elseif (isset($_SERVER["HTTP_FORWARDED"]) && $this->validip($_SERVER["HTTP_FORWARDED"])) {
			return $_SERVER["HTTP_FORWARDED"];
		} elseif (isset($_SERVER["HTTP_X_FORWARDED"]) && $this->validip($_SERVER["HTTP_X_FORWARDED"])) {
			return $_SERVER["HTTP_X_FORWARDED"];
		} else {
			if (isset($_SERVER["REMOTE_ADDR"]))
			{
				return $_SERVER["REMOTE_ADDR"];
			}
		}
		
		return("NO IP");
		
	}
	
}