<?php
//Including html header and curl method files
$docroot = $_SERVER['DOCUMENT_ROOT']."/starwars/libraries/";
$log_file = "IyappanKrishnasamy.log";
include("config.html");
include($docroot."curlCall.php");
echo "<div class=".'"container"'.">";
echo "<h2>PHP script named lists all character names in the film 'Return Of The Jedi'</h2>";
//Curl call to get the provided movie details.
$starwarsAPI = new StarWars();
$characters = $starwarsAPI->multiRequest(['https://swapi.dev/api/films/3/']);

$characterName = $starwarsAPI->characterList(["https://swapi.dev/api/people/?page=1","https://swapi.dev/api/people/?page=2","https://swapi.dev/api/people/?page=3","https://swapi.dev/api/people/?page=4","https://swapi.dev/api/people/?page=5","https://swapi.dev/api/people/?page=6","https://swapi.dev/api/people/?page=7","https://swapi.dev/api/people/?page=8","https://swapi.dev/api/people/?page=9"]);

echo "<div class=".'"table-responsive"'.">";
echo "<table class=".'"table"'.">";

//Looping through the movie array to get the list of characters avaiablle
foreach($characters as $character){
    $character = json_decode($character,true);
    echo "<thead>";
        echo "<tr>";
            echo "<th>";
                echo "Movie Name:  ".$character['title'];
            echo "</th>";
        echo "</tr>";
    echo "</thead>";
    $character_array = $character['characters'];
}
echo "<tr>";
echo "<td><b>Characters in the Movie:</b></td>";
echo "</tr>";
//Preparing the array with URL and Name
foreach($characterName as $charName){
    $charName = json_decode($charName,true);
    $charNamee[$charName['url']] = $charName['name'];
}
//Looping through the array and checking for the value and display
foreach($character_array as $character_name){
    if(array_key_exists($character_name,$charNamee)){
        echo "<tr><td>";
            echo $charNamee[$character_name];
        echo "</td></tr>";
    }
}

echo "</table>";
echo "</div>";
?>
</body>
</html>	