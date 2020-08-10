<?php
/*
 * Class for Boolean type schema
 */
namespace JSONSchema\TypeClasses;

use JSONSchema\TypeClasses\Constraints;

class TypeChoices extends Constraints implements TypeCheck {

    //Error collection
    protected $error_nodes = [];
    
    //Define schema object
    protected $node_object;
    
    //Input JSON object
    protected $inputjson;

    //Initialize schema
    public function __construct($node_object, $inputjson) {
        $this->node_object = $node_object;
        $this->inputjson = $inputjson;
    }

    //validate data type
    public function validateType() {

        if (in_array($this->inputjson, $this->node_object->choices)) {
            return true;
        }

        $this->error_nodes[] = sprintf("Invalid value for '%s'. Must be one of the values in {%s}", $this->node_object->name, join(",", $this->node_object->choices));
        return false;
    }

}
?>