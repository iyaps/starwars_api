<?php
//Including html header, db config and curl method files
$log_file = "IyappanKrishnasamy.log";
$docroot = $_SERVER['DOCUMENT_ROOT']."/starwars/libraries/";
include("config.html");
include($docroot."curlCall.php");
include($docroot."sqlValidator.php");
include($docroot."db_connect.php");
echo "<div class=".'"container"'.">";
echo "<h2>Populate the database table(characters), with all characters available in the API. This code needs to call the remote API directly.</h2>";
//Initialize api class
$starwarsAPI = new StarWars();
//calling the characters,homeworld and species method
$characters = $starwarsAPI->characterList(["https://swapi.dev/api/people/?page=1","https://swapi.dev/api/people/?page=2","https://swapi.dev/api/people/?page=3","https://swapi.dev/api/people/?page=4","https://swapi.dev/api/people/?page=5","https://swapi.dev/api/people/?page=6","https://swapi.dev/api/people/?page=7","https://swapi.dev/api/people/?page=8","https://swapi.dev/api/people/?page=9"]);
$homeWorld = $starwarsAPI->planetsList(["https://swapi.dev/api/planets/?page=1","https://swapi.dev/api/planets/?page=2","https://swapi.dev/api/planets/?page=3","https://swapi.dev/api/planets/?page=4","https://swapi.dev/api/planets/?page=5","https://swapi.dev/api/planets/?page=6","https://swapi.dev/api/planets/?page=7"]);
$species = $starwarsAPI->speciesList(["https://swapi.dev/api/species/?page=1","https://swapi.dev/api/species/?page=2","https://swapi.dev/api/species/?page=3","https://swapi.dev/api/species/?page=4"]);


$character_array = [];
foreach($characters as $character){
    $character = json_decode($character);
    //get the homeworld and species url used in characters
    $characterHomeworld = $character->homeworld;
    $characterSpecies = $character->species;
    //Match the URL with the name in homeworld and species array
    if(array_key_exists($characterHomeworld,$homeWorld)){
        $characterHomeworld = $homeWorld[$characterHomeworld];            
    }
    if(!empty($characterSpecies)){
    foreach($characterSpecies as $characterSpec){
        if(array_key_exists($characterSpec,$species[0])){
            $characterSpecies = $species[0][$characterSpec];
        }
    }
    }else{
        $characterSpecies ="NA";
    }
    //Prepare the initial array 
    $character_array['name'] = $character->name;
    $character_array['height'] = $character->height;
    $character_array['mass'] = $character->mass;
    $character_array['hair_color'] = $character->hair_color;
    $character_array['skin_color'] = $character->skin_color;
    $character_array['eye_color'] = $character->eye_color;
    $character_array['birth_year'] = $character->birth_year;
    $character_array['gender'] = $character->gender;
    $character_array['homeworld'] = $characterHomeworld;
    $character_array['species'] = $characterSpecies;
 
    $prep = [];
    error_log("\nCount of characters in the specified schema".print_r(count($character_array),true),3,$log_file);
    error_log("\nPreparing characters in the specified schema".print_r($character_array,true),3,$log_file);
    //preparing data as values for pushing into table.
    foreach($character_array as $k => $v ) {
        if($k=="species"){
            $v = str_replace("'","\'", $v);
        }
        $prep[':'.$k] = "'".$v."'";
    }
    $sth = "INSERT INTO characters( " . implode(', ',array_keys($character_array)) . ") VALUES (" . implode(', ',array_values($prep)) . ")";
    error_log("\nInsert queries. Inserted successfully".print_r($sth,true),3,$log_file);
    $sqlqueries[] = $sth;
    
    //Initialise the sqlvalidatio
    $sqlvalidator = new SQLValidation();
    foreach ($sqlqueries as $query) {
        //validate each query
        $checkmysql = $sqlvalidator->checkMySqlSyntax($connect_mysql, $query);
        if($checkmysql){
            $sql_error[] = $checkmysql;
        }else{
            $sql_pass[] = $query.'query pass';
        }
    }
    //If sql found error then return false with error
    if(isset($sql_error) && !empty($sql_error)){
        echo "cannot proceed. Please fix the errors";
        foreach($sql_error as $sqlerr){
            echo "<br>".$sqlerr;
        }
        return false;
    }
    
    //Finally insert to table
    if ($connection->query($sth) === TRUE) {
        echo "<h3>Records Inserted successfully into Character table</h3>";
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}

echo "</div>";
?>
</body>
</html>	