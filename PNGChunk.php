<?php

namespace SliveredMindOps\PNGParser;

require_once('Utils/Stream.php');

class PNGChunk {
	//https://www.w3.org/TR/PNG/#5Chunk-layout
	public $length;
	public $type;
	public $data;
	public $crc;

	public function __construct($stream)
	{
		$this->length = $stream->readUInt();
		$this->type = $stream->readString(4);
		if($this->length > 0){
			$this->data = $stream->read($this->length);
		}
		$this->crc = $stream->read(4);
	}

	//pack data again
	public function getData(){
		$data = [];
		$data = array_merge($data, unpack('C*', pack('N', $this->length)));
		$data = array_merge($data, unpack('C*', $this->type));
		if($this->length > 0){
			$data = array_merge($data, $this->data);
		}
		$data = array_merge($data, $this->crc);
		return $data;
	}
}