<?php

interface IDataSource{
	public function readData();
	public function writeData($data);
}

class FileDataSource implements IDataSource{
	private $filename;

	public function __construct($filename){
		$this->filename=$filename;
	}

	public function readData(){
		return "Reading File : ".$this->filename."\n";
	}

	public function writeData($data){
		return "Writing ".$data." to  File : ".$this->filename."\n";
	}
}

//The Base Decorator that simply delegates all work to wrapped component WIHOUT adding any Logic

class DataSourceDecorator implements IDataSource{ //Wrapper

	/*
	*@var DataSource
	*/
	protected $wrapee; 

	public function __construct(IDataSource $dataSource){
		$this->wrapee=$dataSource;
	}

	public function readData(){
		return $this->wrapee->readData();
	}

	public function writeData($data){
		return $this->wrapee->writeData($data);
	}


}


class EncryptionDecorator implements IDataSource{ //Wrapper

	/*
	*@var DataSource
	*/
	protected $wrapee; 

	public function __construct(IDataSource $dataSource){
		$this->wrapee=$dataSource;
	}

	public function readData(){
		return "Decrypting Data, " .$this->wrapee->readData();
	}

	public function writeData($data){
		return "Encrypting Data , " .$this->wrapee->writeData($data);
	}


}


class CompressionDecorator implements IDataSource{ //Wrapper

	/*
	*@var DataSource
	*/
	protected $wrapee; 

	public function __construct(IDataSource $dataSource){
		$this->wrapee=$dataSource;
	}

	public function readData(){
		return "DeCompressing  Data, " .$this->wrapee->readData();
	}

	public function writeData($data){
		return "Compressing Data , " .$this->wrapee->writeData($data);
	}


}

class Application{


	public function loadSalaries(){
		$source = new CompressionDecorator(new EncryptionDecorator(new FileDataSource("salaries.txt")));
		return $source->readData();
	}

	public function modifySalaries(){
		$source = new CompressionDecorator(new EncryptionDecorator(new FileDataSource("salaries.txt")));
		return $source->writeData(json_encode([
			"employee1"=>100,
			"employee2"=>150,
		]));
	}


}


echo (new Application())->loadSalaries();
echo (new Application())->modifySalaries();











