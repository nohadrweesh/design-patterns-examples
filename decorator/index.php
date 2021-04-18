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


class EncryptionDecorator extends DataSourceDecorator{ //Wrapper

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


class CompressionDecorator extends DataSourceDecorator{ //Wrapper

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

//SIMPLE Usage ,the client Code here know exactly what dedorators it needs
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



//Dynamically determine decorators(configuration at runtime)


class SalaryManager{
	private $source;//IDataSource

	public function __construct(IDataSource $dataSource){
		$this->source=$dataSource;
	}

	public function load(){
		return $this->source->readData();
	}

	public function save(){
		$salaryRecords=[
			"employee3"=>113,
			"employee4"=>320,
		];
		return $this->source->writeData(json_encode($salaryRecords));
	}
}

class ApplicationConfigurator{
	private $enableCompression;
	private $enableEncryption;

	public function __construct(){
		$this->enableCompression=true;
		$this->enableEncryption=true;
	}

	public function simulateRead(){
		$source= new FileDataSource('salaries.txt');

		if($this->enableCompression)
			$source=new CompressionDecorator($source);
		if($this->enableEncryption)
			$source=new EncryptionDecorator($source);

		$manager =new SalaryManager($source);
		return $manager->load();
	}

}


echo (new ApplicationConfigurator())->simulateRead();











