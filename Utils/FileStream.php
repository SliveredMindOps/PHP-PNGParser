<?php

namespace SliveredMindOps\PNGParser\Utils\Streams;

require_once('Stream.php');

class FileStream extends Stream {
	private $handle;

	public function __construct(string $path)
	{
		if(!file_exists($path)){
			$this->handle = NULL;
			return;
		}

		$this->handle = fopen($path,'rb');
	}

	public function read(int $length){
		return unpack('C*', fread($this->handle, $length));
	}

	public function readString(int $length){
		return fread($this->handle, $length);
	}

	public function readUInt(){
		return unpack('N', fread($this->handle, 4))[1];
	}

	public function canRead(){
		return $this->handle && !feof($this->handle);
	}

	public function getPosition(){
		return ftell($this->handle);
	}

	public function getLength(){
		return fstat($this->handle)['size'];
	}

	public function dispose(){
		fclose($this->handle);
	}
}