<?php
//Including header and db config
$log_file = "IyappanKrishnasamy.log";
$docroot = $_SERVER['DOCUMENT_ROOT']."/starwars/libraries/";
include("config.html");
include($docroot."db_connect.php");
echo "<div class=".'"container"'.">";
echo "<h2>Update the data in characters table with the data provided in table 'CharacterUpdates'</h2>";
error_log("Update Characters:Processing date: ".date('Y-m-d H:i:s'),3,$log_file);

//Query for updating characters tables with the data from characterupdates table.
$update_query = $connection->query(
    "UPDATE characters c1
    INNER JOIN characterupdates c2
        ON c1.name = c2.name
    SET c1.height = c2.height,
        c1.mass =  c2.mass,
        c1.hair_color = c2.hair_color,
        c1.skin_color = c2.skin_color,
        c1.eye_color = c2.eye_color,
        c1.birth_year = c2.birth_year,
        c1.gender = c2.gender,
        c1.homeworld = c2.homeworld_name,
        c1.species = c2.species_name;");
error_log("<br>Update query<br>".print_r($update_query,1),3,$log_file);
//update query executed.
if ($update_query) {
    echo "<h3>Records in character table updated successfully based on characterupdates table</h3>";
} else {
    echo "<h3>Error updating record: ".mysqli_error($connection)."</h3>";
}
echo "</div>";
?>
</body>
</html>	