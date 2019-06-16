<?php

namespace SliveredMindOps\PNGParser\Utils\Log;

require_once('Logger.php');
require_once('../Constants.php');

class DebugLogger extends Logger {
	public function out(string $logData){
		if(DEBUG){
			echo $logData;
		}
	}
}