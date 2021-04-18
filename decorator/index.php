<?php


class DataSource{
	private $filename;

	public function __construct($filename){
		$this->filename=$filename;
	}

	public function readFile(){
		return "Reading File : ".$this->filename."\n";
	}

	public function writeData($data){
		return "Writing ".$data." to  File : ".$this->filename."\n";
	}
}

class Application{


	public function loadSalaries(){
		$source = new DataSource("salaries.txt");
		return $source->readFile();
	}

	public function modifySalaries(){
		$source = new DataSource("salaries.txt");
		return $source->writeData(json_encode([
			"employee1"=>100,
			"employee2"=>150,
		]));
	}


}


echo (new Application())->loadSalaries();
echo (new Application())->modifySalaries();











