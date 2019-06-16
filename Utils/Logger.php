<?php

namespace SliveredMindOps\PNGParser\Utils\Log;

abstract class Logger {
	private static $instance;

	public static function set($instance){
		self::$instance  = $instance;
	}

	public static function get(){
		return self::$instance;
	}

	abstract public function out(string $logData);
}