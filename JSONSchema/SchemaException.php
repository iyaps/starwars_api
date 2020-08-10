<?php
/*
 * Exception class for schemavalidator
 */
namespace JSONSchema;

class SchemaException extends Exception {

    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /*
     * convert class to string and return
     */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}
?>