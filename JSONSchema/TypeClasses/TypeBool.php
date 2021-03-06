<?php

/*
 * Class for Boolean type schema
 */
namespace JSONSchema\TypeClasses;

use JSONSchema\TypeClasses\Constraints;

class TypeBool extends Constraints implements TypeCheck {

    //Error collection
    protected $error_nodes = [];

    //Define Schema object
    protected $node_object;

    //Input JSON object
    protected $inputjson;

    //Initialize shcema object
    public function __construct($node_object, $inputjson) {
        $this->node_object = $node_object;
        $this->inputjson = $inputjson;
    }

    //Validate data type
    public function validateType() {

        if (filter_var($this->inputjson, FILTER_VALIDATE_BOOLEAN, array('flags' => FILTER_NULL_ON_FAILURE)) === null) {
            $this->error_nodes[] = sprintf("Invalid data type for '%s'", $this->node_object->name);
            return false;
        }
        return true;
    }

}
?>