<?php
/*
 * Class for text type schema
 */
namespace JSONSchema\TypeClasses;

use JSONSchema\TypeClasses\Constraints;

class TypeText extends Constraints implements TypeCheck {

    //Error collection
    protected $error_nodes = [];

    //Define schema object
    protected $node_object;

    //Input JSON object
    protected $inputjson;

    //Initialize shcema object
    public function __construct($node_object, $inputjson) {
        $this->node_object = $node_object;
        $this->inputjson = $inputjson;
    }

    //validate data type for text
    public function validateType() {

        if (!is_string($this->inputjson)) {
            $this->error_nodes[] = sprintf("Invalid data type for '%s'", $this->node_object->name);
            return false;
        }

        return parent::validateLength();
    }

}
?>