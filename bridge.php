<?php

// Implementation Interface
interface Workshop {
    public function work();
}

// Concrete Implementations
class Produce implements Workshop {
    public function work() {
        echo "Producing parts...\n";
    }
}

class Assemble implements Workshop {
    public function work() {
        echo "Assembling parts...\n";
    }
}

// Abstraction
abstract class Vehicle {
    protected $workshop1;
    protected $workshop2;

    public function __construct(Workshop $workshop1, Workshop $workshop2) {
        $this->workshop1 = $workshop1;
        $this->workshop2 = $workshop2;
    }

    abstract public function manufacture();
}

// Refined Abstraction 1
class Car extends Vehicle {
    public function manufacture() {
        echo "Car manufacturing process:\n";
        $this->workshop1->work();
        $this->workshop2->work();
    }
}

// Refined Abstraction 2
class Bike extends Vehicle {
    public function manufacture() {
        echo "Bike manufacturing process:\n";
        $this->workshop1->work();
        $this->workshop2->work();
    }
}

// Client Code
$car = new Car(new Produce(), new Assemble());
$car->manufacture();

echo "\n";

$bike = new Bike(new Produce(), new Assemble());
$bike->manufacture();
