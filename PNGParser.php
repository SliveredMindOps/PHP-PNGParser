<?php

namespace SliveredMindOps\PNGParser;

require_once('Utils/Stream.php');
require_once('Utils/FileStream.php');
//require_once('Utils/ArrayStream.php');
require_once('Utils/Logger.php');
require_once('PNGChunk.php');
require_once('Constants.php');


if(DEBUG){
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
}

class PNGImage 
{
	/* Data */
	public $magic;
	public $chunks = [];

	private $stream;

	private function __construct($stream)
	{
		$this->stream = $stream;
		$this->parse();
	}

	//parse png image
	public static function fromFile(string $path){
		$fileStream = new Utils\Streams\FileStream($path);
		if(!$fileStream->canRead()){
			return NULL;
		}

		return new PNGImage($fileStream);
	}

	/*@TODO
	public static function fromData(array $data){

	}*/

	//parse file
	private function parse(){
		try{
			$this->magic = $this->stream->read(8);
			if($this->magic !== MAGIC){
				Utils\Log\Logger::get()->out('Unable to verify magic');
			}

			while ($this->stream->getPosition() < $this->stream->getLength()) {
				array_push($this->chunks, new PNGChunk($this->stream));
			}
		}
		catch(Exception $e){
			Utils\Log\Logger::get()->out('Failed to parse data. Exception:' . $e);
		}
	}

	//create byte array from magic and chunks
	public function build(){
		$data = [];
		$data = array_merge($data, $this->magic);
		for ($i=0; $i < count($this->chunks); $i++) { 
			$data = array_merge($data, $this->chunks[$i]->getData());
		}
		
		return $data;
	}

	//write magic and chunks to file
	public function write(string $path){
		try{
			$build_data = $this->build();
			$handle = fopen($path,'wb');
			$tmp_data = "";
			foreach($build_data as $data) {
				$tmp_data .= pack("C", $data);
			}
			fwrite($handle, $tmp_data);
			fclose($handle);
		}
		catch(Exception $e){
			Utils\Log\Logger::get()->out('Failed to parse data. Exception:' . $e);
		}
	}

	//dispose object
	public function dispose(){
		$this->stream->dispose();
	}
}

