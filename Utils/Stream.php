<?php

namespace SliveredMindOps\PNGParser\Utils\Streams;

abstract class Stream {
	abstract public function read(int $number);
	abstract public function readString(int $number);
	abstract public function readUInt();
	abstract public function canRead();
	abstract public function getPosition();
	abstract public function getLength();
	abstract public function dispose();
}