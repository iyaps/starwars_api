<?php
//Including html header and curl method files
$docroot = $_SERVER['DOCUMENT_ROOT']."/starwars/libraries/";
include("config.html");
include($docroot."curlCall.php");

echo "<div class=".'"container"'.">";
echo "<h2>Lists all Mammals(species) in all Star Wars films, and the name of their homeworld</h2>";
echo "<div class=".'"table-responsive"'.">";
echo "<table class=".'"table"'.">";


//api class initialization.
$starwarsAPI = new StarWars();

//call specieslist and store the species name in an array
$species = $starwarsAPI->speciesList(["https://swapi.dev/api/species/?page=1","https://swapi.dev/api/species/?page=2","https://swapi.dev/api/species/?page=3","https://swapi.dev/api/species/?page=4"]);
foreach($species as $key=>$specie){
    if($key==0){
        $specie_name = $specie;
    }else{
        $homeworld_name = $specie;
    }
    
}

//api call to get the movies detail and iteration to get the details.
$movies = $starwarsAPI->multiRequest(["https://swapi.dev/api/films/1/","https://swapi.dev/api/films/2/","https://swapi.dev/api/films/3/","https://swapi.dev/api/films/4/","https://swapi.dev/api/films/5/","https://swapi.dev/api/films/6/","https://swapi.dev/api/films/7/"]);

//Looping through the array/object to display the species and homeworld along with the movies.
foreach($movies as $movie){
    $movie = json_decode($movie,true);
    //display the movie info
    foreach($movie as $key=>$move){
        if($key=="title"){
            echo "<thead>";
                echo "<tr>";
                echo "<th colspan=2>";
                echo "Movie Title:  ".$move;
                echo "</th>";
                echo "</tr>";
            echo "</thead>";
        }
        //display the associate species and homeworld info
        if($key=="species"){
            echo "<thead><tr><th>Species</th><th>HomeWorld</th></tr><thead>";
            foreach($move as $spec){
                if(array_key_exists($spec,$specie_name)){
                    echo "<tr>";
                    echo "<td>".$specie_name[$spec]."</td>";
                    if(array_key_exists($specie_name[$spec],$homeworld_name)){
                        $homew = isset($homeworld_name[$specie_name[$spec]])?$homeworld_name[$specie_name[$spec]]:"NA";
                        echo "<td>".$homew."<td>";
                    }
                    echo "</tr>";
                }
            }
            
        }
    }
}
echo "</table>";
echo "</div>";
?>
</body>
</html>	