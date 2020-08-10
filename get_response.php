<?php
$docroot = $_SERVER['DOCUMENT_ROOT']."/starwars/libraries/";
include($docroot."db_connect.php");
include($docroot."curlCall.php");
include($docroot."sqlValidator.php");
$log_file = "IyappanKrishnasamy.log";
//declaring the objects for api call and sql validator
$starwarsAPI = new StarWars();
$sqlvalidator = new SQLValidation();

//assigning the post variables
$charName = $_POST['char_name'];
$height = $_POST['height'];
$mass = $_POST['mass'];
$hair_color = $_POST['hair_color'];
$skin_color = $_POST['skin_color'];
$eye_color = $_POST['eye_color'];
$birth_year = $_POST['birth_year'];
$gender = $_POST['gender'];
$homeworld = $_POST['homeworld'];
$species = $_POST['species'];

//Preparing the array with necessary columns
$character_array = array('name'=>$charName, 'height'=> $height, 'mass' =>$mass,
    'hair_color'=>$hair_color, 'skin_color'=>$skin_color,'eye_color'=>$eye_color,
    'birth_year'=>$birth_year,'gender'=>$gender,'homeworld'=>$homeworld,'species'=>$species);
error_log("\nCharacter array with the values from form :".print_r($character_array,true),3,$log_file);

//validating the prepared array and return false if found false
$character_array = $starwarsAPI->validateJSON(array(json_encode($character_array)), "peopleadd");
if(!is_array($character_array)){
    if(strpos($character_array, 'JSON not validated') !== false) {
        echo "There is an issue in the input data. Quitting!";
        return false;
    }
}


//Check whether the provided name is existing in table and 
//if existing return to provide different name
//If not existing insert into characters table
$select_query = $connection->query(
    "select id FROM
        CHARACTERS
        WHERE name = '".$charName."'"); 
error_log("\nChecking the CHARACTERS table for the existing name:".print_r($select_query,true),3,$log_file);
if(mysqli_num_rows($select_query)==1){
    echo "Please provide a different character as the given name(".$charName.") already exists";
}else{
    $sth = "INSERT INTO characters(name, height, mass, hair_color, skin_color, eye_color, birth_year, gender, homeworld, species) 
            VALUES ('".$charName."', '".$height."','".$mass."','".$hair_color."','".$skin_color."','".$eye_color."','".$birth_year."','".$gender."','".$homeworld."','".$species."')";
    error_log("\nPrepared insert query for characters table:".print_r($sth,true),3,$log_file);
    $checkmysql = $sqlvalidator->checkMySqlSyntax($connect_mysql, $sth);
    error_log("\nValidated SQL report:".print_r($checkmysql,true),3,$log_file);
    if($checkmysql){
        echo $checkmysql;
        return false;
    }
    if ($connection->query($sth) === TRUE) {
        error_log("\nRecords Inserted successfully into Character table",3,$log_file);
        echo "Records Inserted successfully into Character table";
    } else {
        echo "Error: ".$connection->error;
    } 
}
?>