<?php
include("db_connect.php");
$connect_mysql = new mysqli($servername, $username, $password, $dbname);
/*
 * Class for SQL validation to check the syntax of the SQL and the elements used in it.
 * Gets the structure from the table and compare with the provided query
 * 
 */
class SQLValidation{
    /*
     * Checks the mysql syntax and fails if not found fine.
     * var @mysqli db connect params
     * var @query query to be validated
     */
    public function checkMySqlSyntax($mysqli, $query) {
       if ( trim($query) ) {
          // Replace literals within strings that may *** up the process by dummies
          $query = self::replaceCharacterWithinQuotes($query, '#', '%') ;
          $query = self::replaceCharacterWithinQuotes($query, ';', ':') ;
          // Prepare the query to make a valid EXPLAIN query
          $query = "EXPLAIN " .
                   preg_replace(Array("/#[^\n\r;]*([\n\r;]|$)/",
                                  "/[Ss][Ee][Tt]\s+\@[A-Za-z0-9_]+\s*=\s*[^;]+(;|$)/",
                                  "/;\s*;/",
                                  "/;\s*$/",
                                  "/;/"),
                            Array("","", ";","", "; EXPLAIN "), $query) ;
    
          foreach(explode(';', $query) as $q) {
             $result = $mysqli->query($q) ;
             $err = !$result ? $mysqli->error : false ;
             if ( ! is_object($result) && ! $err ) $err = "Unknown SQL error";
             if ( $err) return $err ;
          }
          return false ;
      }
    }
    
    /*
     * replacing the character within the quotes
     * var @str string need to be checked
     * var @char character need to be checked
     * var @repl character need to be replaced
     */    
    public function replaceCharacterWithinQuotes($str, $char, $repl) {
        if ( strpos( $str, $char ) === false ) return $str ;
    
        $placeholder = chr(7) ;
        $inSingleQuote = false ;
        $inDoubleQuotes = false ;
        for ( $p = 0 ; $p < strlen($str) ; $p++ ) {
            switch ( $str[$p] ) {
                case "'": if ( ! $inDoubleQuotes ) $inSingleQuote = ! $inSingleQuote ; break ;
                case '"': if ( ! $inSingleQuote ) $inDoubleQuotes = ! $inDoubleQuotes ; break ;
                case '\\': $p++ ; break ;
                case $char: if ( $inSingleQuote || $inDoubleQuotes) $str[$p] = $placeholder ; break ;
            }
        }
        return str_replace($placeholder, $repl, $str) ;
     }
}

?>