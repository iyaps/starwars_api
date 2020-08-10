<?php

/**
 * This is the main class that will check the JSON schema and
 * will attempt to validate input JSON payload.
 */

namespace JSONSchema;

use JSONSchema\SchemaException;
use JSONSchema\TypeClasses\TypeText;
use JSONSchema\TypeClasses\TypeNumeric;
use JSONSchema\TypeClasses\TypeDate;
use JSONSchema\TypeClasses\TypeValidation;
use JSONSchema\TypeClasses\TypeArray;
use JSONSchema\TypeClasses\TypeChoices;
use JSONSchema\TypeClasses\TypeBool;

class JsonSchemaValidator {
    //Class mapping
    private $type_check_classes = [
        'text' => TypeText::class,
        'numeric' => TypeNumeric::class,
        'date' => TypeDate::class,
        'array' => TypeArray::class,
        'boolean' => TypeBool::class,
        'choices' => TypeChoices::class,
    ];

    //Errors collection
    private $error_nodes = [];

    public $validated = true;

    /**
     * start validating schema
     * @param schema accepts the array
     * @param json_payload
     */
    public function validateSchema($schema, $json_payload) {

        if (!is_array($schema)) {
            throw new SchemaException("Invalid schema definition in method: " . __FUNCTION__ . " / Class: " . __CLASS__, 1001);
            return false;
        }

        $json_payload = json_decode($json_payload);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new SchemaException("Invalid JSON input", 1002);
            return false;
        }

        $this->recursive_walk($schema, $json_payload);
        
        return $this->validated;
    }

    /**
     * Recursive schema walker.
     * @param  schema array
     * @param json_payload object
     */
    private function recursive_walk($schema, $json_payload) {

        foreach ($schema as $nodes => $value) {

            $node_name = isset($value['node']['name']) ? $value['node']['name'] : null;
            $type = isset($value['node']['type']) ? $value['node']['type'] : null;
            $required = isset($value['node']['required']) ? $value['node']['required'] : '';
            $sub_nodes = isset($value['node']['sub_nodes']) ? $value['node']['sub_nodes'] : false;

            if ($node_name === null || $type === null) {
                throw new SchemaException("Invalid schema definition in method: " . __FUNCTION__ . " / Class: " . __CLASS__, 1001);
                return false;
            }

            //check whether available
            if (!isset($json_payload->$node_name)) {
                $this->error_nodes[] = sprintf("'%s' does not exists.", $node_name);
                $this->validated = false;
                continue;
            }

            //if object then perform recursion
            if ($type == "object") {
                $this->recursive_walk($sub_nodes, $json_payload->$node_name);
                return;
            }
            
            //call validator classes
            $typeValidater = new $this->type_check_classes[$type]((object) $value['node'], $json_payload->$node_name);

            $validated = (new TypeValidation($typeValidater))->callValidator($type);

            
            //final result and display error
            $this->validated = !$validated ? false : $this->validated;

            if (!$validated) {
                $this->error_nodes = array_merge($this->error_nodes, $typeValidater->getErrors());
            }
        }
    }

    /*
     * return errors
     */
    public function getErrors() {
        return $this->error_nodes;
    }

}
?>
