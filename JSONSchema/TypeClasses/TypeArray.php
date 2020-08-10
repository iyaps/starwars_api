<?php
/*
 * class for array type schema
 */
namespace JSONSchema\TypeClasses;

use JSONSchema\TypeClasses\Constraints;


class TypeArray extends Constraints implements TypeCheck {

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

    //Validate data type
    public function validateType() {
        
        if(!is_array($this->inputjson)){
            $this->error_nodes[] = sprintf("Invalid data type for '%s'", $this->node_object->name);
            return false;
        }        
       
        return parent::itemsCountCheck();
    }
    
}
?>