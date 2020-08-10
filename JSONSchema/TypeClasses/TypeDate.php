<?php
/*
 * Class for Date type schema
 */
 
namespace JSONSchema\TypeClasses;

use JSONSchema\TypeClasses\Constraints;

class TypeDate extends Constraints implements TypeCheck {

    //Error collection
    protected $error_nodes = [];

    //Define schema object
    protected $node_object;

    // Input JSON object
    protected $inputjson;

    //Initialize schema
    public function __construct($node_object, $inputjson) {
        $this->node_object = $node_object;
        $this->inputjson = $inputjson;
    }

    //validate data type date
    public function validateType() {

        if (!strtotime($this->inputjson)) {
            $this->error_nodes[] = sprintf("Invalid data type for %s. Acceptable format: YYYY-MM-DD HH:ii:ss", $this->node_object->name);
            return false;
        }

        return true;
    }

}
?>