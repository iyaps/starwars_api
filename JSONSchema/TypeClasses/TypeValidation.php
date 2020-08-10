<?php
/*
 * class for data type validator
 */

namespace JSONSchema\TypeClasses;

use JSONSchema\JsonSchemaValidator;
use JSONSchema\TypeClasses;
use JSONSchema\TypeClasses\Constraints;

class TypeValidation {

    private $validator;

    public function __construct(TypeCheck $validator) {
        $this->validator = $validator;
    }

    //Method to call data type validator classes
    public function callValidator($datatype) {

        if ($datatype != "boolean")
            if ($this->validator->isBlank()) {
                return false;
            }

        return $this->validator->validateType();
    }

}
?>