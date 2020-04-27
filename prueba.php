<?php

class base_class {

    function say_a() {
        echo "'a' - said the " . __CLASS__ . "pene<br/>";
    }

    function say_b() {
        echo "'b' - said the " . get_class($this) . "<br/>";
    }

}

class derived_class extends base_class {

    function say_a() {
        parent::say_a();
        echo "'a' - said the " . __CLASS__ . "<br/>";
    }

    function say_b() {
        parent::say_b();
        echo "'b' - said the " . get_class($this) . "<br/>";
    }

}

$obj_b = new derived_class();

    

$obj_b->say_a();
echo "<br/>";
$obj_b->say_b();
