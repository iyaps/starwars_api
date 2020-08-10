<?php
set_time_limit(150);
require_once("Autoloader.php");
use JSONSchema\JsonSchemaValidator;
/**
 * StarWars class with multirequest method and other associated method for api call using curl
 * includes validateJSON function to valiadate the JSON returned through API
 * contains separate function for values like people, species, vehicles
 * @author iyappan
 *
 */

class StarWars{
    /*
     * common variable for log file path
     */
    function __construct(){
        $this->log_file = "./IyappanKrishnasamy.log";
    }
    /*
     * Function to make a multi request api with single parameter
     * param @data = array containing the api request
     */
    public function multiRequest($data) {
        
        // array of curl handles
        $curly = array();
        // data to be returned
        $result = array();
        
        
        // multi handle
        $mh = curl_multi_init();
        error_log("\nInitial Request: ".date('Y-m-d H:i:s').print_r($data,true),3, $this->log_file);
        error_log("\nTotal count of data passed: ".print_r(count($data),true),3, $this->log_file);
        // loop through $data and create curl handles
        // then add them to the multi-handle
        foreach ($data as $id => $d) {
            
            $curly[$id] = curl_init();
            error_log("\nprocessing each Request: ".print_r($d,true),3,$this->log_file);
            $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
            curl_setopt($curly[$id], CURLOPT_URL,            $url);
            curl_setopt($curly[$id], CURLOPT_HEADER,         0);
            curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curly[$id], CURLOPT_CONNECTTIMEOUT, 0);
            
            // post data
            if (is_array($d)) {
                if (!empty($d['post'])) {
                    curl_setopt($curly[$id], CURLOPT_POST,       1);
                    curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
                }
            }
            $multihandle = curl_multi_add_handle($mh, $curly[$id]);
        }
        
        // execute the handles
        $running = null;
        do {
            $multiexec = curl_multi_exec($mh, $running);
            } while($running > 0);
        
        
        // get content and remove handles
        foreach($curly as $id => $c) {
            $result[$id] = curl_multi_getcontent($c);
            error_log("\nGetting content of each requests: ".print_r($result[$id],true),3,$this->log_file);
            curl_multi_remove_handle($mh, $c);
        }
        
        // all done
        curl_multi_close($mh);
        foreach($result as $res){
            $res = json_decode($res,true);
            if(@$res['count'] && !empty(@$res['count'])){
                error_log("\nPassing to the pagination function as the data has to be separated and converted it to JSON: ",3,$this->log_file);
                return self::convertPagination($result);
            }else{
                error_log("\nPassing to the validate JSON function",3,$this->log_file);
                return self::validateJSON($result);
            }
        }
     
    }
    /*
     * to conver the pagination array to the required array
     * param @result passing the result array from multirequest api function
     */
    public function convertPagination($result){
        //loop through the result array and decode
        foreach($result as $res){
            $resu[] = json_decode(json_encode($res));
          
        }
        //iterating to seprate the results part
        foreach($resu as $keya=>$resupage){
            $resupage = json_decode($resupage);  
            
            foreach($resupage as $key=>$rrr){
                
                if($key=="results"){
                    $resuu[] = json_encode($rrr);
                }
          }
        }
        //Merging the various pagination resultant arrays and again encoding it.
        $resultt = [];
        foreach($resuu as $array){
            $array = json_decode($array,true);
            $resultt = array_merge($resultt, $array);
        }
        $resds = [];
        foreach($resultt as $key=>$ress){
            $resds[$key] = json_encode($ress,JSON_UNESCAPED_SLASHES);
            
        }
        error_log("\nDisplaying the paginated results from the page array".print_r($resds,true),3,$this->log_file);
        //passing it to validateJSON function 
        return self::validateJSON($resds);
     }
    
     /*
      * validating the JSON array with the predefined schema. 
      * retiriveing the schema from schema file 
      * Accepts 2 params 
      * param @result as multirequest api return data
      * param @path pass the schema name
      */
    public function validateJSON($result,$path=false){
        //to get the various schema of JSON avaialble
        include 'schema.php';
        $validated = false;
        //Object initialisation
        $jsonschemavalidator = new JsonSchemaValidator();
        //looping through the api result
        foreach($result as $results){
            //Setting the path if not avaialble in return array
            if(!empty($path)){
                $path = $path;
            }else{
                $path = json_decode($results,true);            
                $path = parse_url($path['url']);
                $path = (explode("/",$path['path'])[2]);
            }
            error_log("\nValidating with the matching schema:".print_r($path."_schema",true),3,$this->log_file);
            //calling validateSchema function to validate the JSON
            try {
                $validated = $jsonschemavalidator->validateSchema(${$path.'_schema'}, $results);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            //Checking whether validated and returns true else return false.
            if($validated){
                error_log("\nValidating each array values with the matching schema: Successfully validated".print_r($result,true),3,$this->log_file);
                error_log("\ncount of validated result:  ".print_r(count($result),true),3,$this->log_file);
               // echo "JSON Validated";
                return $result;
            } else {
                error_log("\nValidating each array values with the matching schema: not validat".print_r($result,true).print_r($jsonschemavalidator->getErrors(),true),3,$this->log_file);
                
                print_r($jsonschemavalidator->getErrors());
                return "JSON not validated";
            }
            //print_r($jsonschemavalidator->getErrors());
            
        }
    }
    
    /*
     * Retrives all the planets list and outputs array with url and name value
     * param @data input the api url
     */
    public function planetsList($data){
        $homeworlds =  self::multiRequest($data);
        $home_world_name = [];
        //loop through the homeworlds array to retrive the URL and Name value as array
        foreach($homeworlds as $homeworld){
            $homeworld = json_decode($homeworld,true);
            $home_world_name[$homeworld['url']] = $homeworld['name'];
        }
        error_log("\nCount of Planet list with the key as url and value as homeworld name: ".print_r(count($home_world_name),true),3,$this->log_file);
        error_log("\nPlanet list with the key as url and value as homeworld name:".print_r($home_world_name,true),3,$this->log_file);
        return $home_world_name;
    }
    
    /*
     * Retreives all the species list along with the palents belong to
     * param @data Input the api url
     */
    public function speciesList($data){
        $home_world_name = self::planetsList(["https://swapi.co/api/planets/?page=1","https://swapi.co/api/planets/?page=2","https://swapi.co/api/planets/?page=3","https://swapi.co/api/planets/?page=4","https://swapi.co/api/planets/?page=5","https://swapi.co/api/planets/?page=6","https://swapi.co/api/planets/?page=7"]);

        $species = self::multiRequest($data);
        $species_name = [];
        $homeworld_name = [];
        //loop through species to get the name and homeworld details
        foreach($species as $key=>$specie){
            $specie = json_decode($specie,true);
            $species_name[$specie['url']] = $specie['name'];
            $homeworld_name[$specie['name']] = $specie['homeworld'];
        }
        //loop through and compare with the species url to replace the url with homeworld
        foreach($homeworld_name as $key=>$hworldname){
            if(array_key_exists($hworldname,$home_world_name)){
                $hworldname = $home_world_name[$hworldname];
            }
            $spec_name[$key] = $hworldname;
        }
        error_log("\nCount of Species list with key as URL and value as name:".print_r(count($species_name),true),3,$this->log_file);
        error_log("\nSpecies list with key as URL and value as name:".print_r($species_name,true),3,$this->log_file);
        error_log("\nCount of Species & Homeworld list with key as Species name and value as homeworld name:".print_r(count($spec_name),true),3,$this->log_file);
        error_log("\nSpecies & Homeworld list with key as Species name and value as homeworld name:".print_r($spec_name,true),3,$this->log_file);
        return [$species_name, $spec_name];
    }
    
    /*
     * Retrieves the character list in all the series
     * param @data input the api url
     */
    public function characterList($data){
       $characters = self::multiRequest($data);
       return $characters;
    }
    
    /*
     * Retrives the vehcile list in all the series and puts in the movies used
     * param @data input the api url
     */
    public function vehicleList($data){
        $vehicles = self::multiRequest($data);
        $vehicle_name = [];
        $vehicle_films = [];
        //Loop through the vehcile array to get the vehicle name and the films used
        foreach($vehicles as $key=>$vehicle){
            $vehicle = json_decode($vehicle,true);
            $vehicle_name[$vehicle['url']] = $vehicle['name'];
            $vehicle_films[$vehicle['name']] = $vehicle['films'];
        }
        return [$vehicle_name, $vehicle_films];
        error_log("\nCount of Vehicle list with key as URL and value as name:".print_r(count($vehicle_name),true),3,$this->log_file);
        error_log("\nVehicle list with key as URL and value as name:".print_r($vehicle_name,true),3,$this->log_file);
        error_log("\nCount of Vehicle list used in films with key as vehicle name and value as films:".print_r(count($vehicle_films),true),3,$this->log_file);
        error_log("\nVehicle list used in films with key as vehicle name and value as films:".print_r($vehicle_films,true),3,$this->log_file);
    }
    
}
?>
