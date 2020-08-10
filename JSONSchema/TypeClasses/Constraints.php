<?php

/*
 * Constraints class for value constraints
 */
namespace JSONSchema\TypeClasses;

use JSONSchema\SchemaException;
use JSONSchema\JsonSchemaValidator;

class Constraints {

    //Check if value exists
    public function isBlank() {

        if (!isset($this->node_object->required)) {
            return false;
        }

        if ($this->node_object->required) {
            if (empty($this->inputjson)) {
                $this->error_nodes[] = sprintf("Value required for '%s'", $this->node_object->name);
                return true;
            }
        } else {
            if (empty($this->inputjson)) {
                return false;
            }
        }

        return false;
    }

    //validate max length of string
    public function validateLength() {

        if (!isset($this->node_object->max_length) || !$this->node_object->max_length)
            return true;

        if (strlen($this->inputjson) > $this->node_object->max_length) {
            $this->error_nodes[] = sprintf("Invalid text length for '%s'", $this->node_object->name);
            return false;
        }

        return true;
    }

    //check number range
    public function numRangeCheck() {

        if (isset($this->node_object->value_range)) {
            $this->node_object->value_range = (object) $this->node_object->value_range;

            if (!isset($this->node_object->value_range->min_value) || !isset($this->node_object->value_range->max_value)) {
                throw new SchemaException("Invalid schema definition in method: " . __FUNCTION__ . " / Class: " . __CLASS__, 1001);
                return false;
            }

            if ($this->inputjson < $this->node_object->value_range->min_value || $this->inputjson > $this->node_object->value_range->max_value) {
                $this->error_nodes[] = sprintf("Items should be in between %d and %d for '%s' ", $this->node_object->value_range->min_value, $this->node_object->value_range->max_value, $this->node_object->name);
                return false;
            }
        }

        return true;
    }

    //check number of items in array
    public function itemsCountCheck() {


        if (!isset($this->node_object->min_item_count) && !isset($this->node_object->max_item_count)) {
            return true;
        }

        if (isset($this->node_object->min_item_count) && !isset($this->node_object->max_item_count)) {
            if (count($this->inputjson) < $this->node_object->min_item_count) {
                $this->error_nodes[] = sprintf("Total number of items should be at least %d for '%s' ", $this->node_object->min_item_count, $this->node_object->name);
                return false;
            } else {
                return true;
            }
        }

        if (!isset($this->node_object->min_item_count) && isset($this->node_object->max_item_count)) {
            if (count($this->inputjson) > $this->node_object->max_item_count) {
                $this->error_nodes[] = sprintf("Total number of items should not exceed %d for '%s' ", $this->node_object->max_item_count, $this->node_object->name);
                return false;
            } else {
                return true;
            }
        }

        if (count($this->inputjson) < $this->node_object->min_item_count || count($this->inputjson) > $this->node_object->max_item_count) {
            $this->error_nodes[] = sprintf("Total number of items should be in between %d and %d for '%s' ", $this->node_object->min_item_count, $this->node_object->max_item_count, $this->node_object->name);
            return false;
        }

        return true;
    }

    //Get errors from constraints
    public function getErrors() {
        $errors = $this->error_nodes;
        return $errors;
    }

}
?>