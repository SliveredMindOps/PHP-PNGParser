<?php

namespace SliveredMindOps\PNGParser;

require_once('Utils/DebugLogger.php');
require_once('Utils/Logger.php');

define('DEBUG', true);

//create your own loggers yay!
Utils\Log\Logger::set(new Utils\Log\DebugLogger());

/* PNG Constants */
//unpack returns an associative array starting with 1...
define('MAGIC', array(1 => 0x89, 2 => 0x50, 3 => 0x4E, 4 => 0x47, 5 => 0x0D, 6 => 0x0A, 7 => 0x1A, 8 => 0x0A));