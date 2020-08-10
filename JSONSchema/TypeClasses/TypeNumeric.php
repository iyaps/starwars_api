<?php
/*
 * Class for Boolean type schema
 */
namespace JSONSchema\TypeClasses;

use JSONSchema\TypeClasses\Constraints;

class TypeNumeric extends Constraints implements TypeCheck {

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

    //Validate data type for numeric
    public function validateType() {

        if (!is_numeric($this->inputjson)) {
            $this->error_nodes[] = sprintf("Invalid data type for %s", $this->node_object->name);
            return false;
        }

        return parent::numRangeCheck();
    }

}
?>