<?php

//Book referes to Library Code that we don't won't to change(or don't have access to change)
interface IBook{

	public function open();
	public function turnPage();

}

class Book implements IBook{

	public function open(){
		var_dump("Opening a paper book");
	}

	public function turnPage(){
		var_dump("Turning a page on a paper book");
	}
}


//eReader code which is the new code that needs to be used in change with book code

interface IeReader{
	public function turnOn();
	public function pressNextButton();
}


class Kindle implements IeReader{


	public function turnOn(){
		var_dump("Turning on a kindle");
	}
	public function pressNextButton(){

		var_dump("Press next button on a kindle");
	}


}

class Nook implements IeReader{


	public function turnOn(){
		var_dump("Turning on a Nook");
	}
	public function pressNextButton(){

		var_dump("Press next button on a Nook");
	}


}

//Create an adapter class and make it implements the interface that we're trying to adapt
class eReaderAdapter implements IBook{
	private $eReader;

	public function __construct(IeReader $eReader){
		$this->eReader=$eReader;
	}

	public function open(){
		return $this->eReader->turnOn();

	}
	public function turnPage(){
		return $this->eReader->pressNextButton();

	}

}
class Person{

	public function read(IBook $book){
		$book->open();
		$book->turnPage();

	}
}
//Original Code

(new Person())->read(new Book);

//new Code using adapter to work with old code
(new Person())->read(new eReaderAdapter(new Kindle));
(new Person())->read(new eReaderAdapter(new Nook));
