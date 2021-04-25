<?php

// the Template Method pattern when you want to let clients extend only particular steps of an algorithm, but not the whole algorithm or its structure.

//Like the addPrimaryToppings method here

abstract class Sub{
    final public function make(){
        return $this->layBread()
                    ->addLettuce()
                    ->addSauces()
                    ->addPrimaryToppings();
    }

    final protected function layBread(){
        var_dump("Laying Bread ...");
        return $this;
    }


    final protected function addLettuce(){
        var_dump("Adding Lettuce ...");
        return $this;
    }

    final protected function addSauces(){
        var_dump("Adding Sauces ...");
        return $this;
    }

    protected abstract function addPrimaryToppings();
}


class VeggieSub extends Sub{

    protected  function addPrimaryToppings(){

        var_dump("Add some Veggie..");
        return $this;
    }

}

class TurkeySub extends Sub{

    protected  function addPrimaryToppings(){

        var_dump("Add some Turkey..");
        return $this;
    }

}

(new VeggieSub)->make();

(new TurkeySub)->make();


