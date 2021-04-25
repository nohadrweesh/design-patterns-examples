<?php

abstract class Sub{
    public function make(){
        return $this->layBread()
                    ->addLettuce()
                    ->addSauces()
                    ->addPrimaryToppings();
    }

    protected function layBread(){
        var_dump("Laying Bread ...");
        return $this;
    }


    protected function addLettuce(){
        var_dump("Adding Lettuce ...");
        return $this;
    }

    protected function addSauces(){
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


