<?php
//including html header and curl function.
$docroot = $_SERVER['DOCUMENT_ROOT']."/starwars/libraries/";
include("config.html");
include($docroot."curlCall.php");
echo "<div class=".'"container"'.">";
echo "<h2>List the name of all vehicles that can have more than 30 characters, and for each matching vehicle, provide the name of the film they appear in</h2>";
echo "<div class=".'"table-responsive"'.">";
echo "<table class=".'"table"'.">";

//api initialisation
$starwarsAPI = new StarWars();

//call multirequest to get the movies json
$movies = $starwarsAPI->multiRequest(["https://swapi.dev/api/films/1/","https://swapi.dev/api/films/2/","https://swapi.dev/api/films/3/","https://swapi.dev/api/films/4/","https://swapi.dev/api/films/5/","https://swapi.dev/api/films/6/","https://swapi.dev/api/films/7/"]);

foreach($movies as $movie){
    $movie = json_decode($movie,true);
    $movie_name[$movie['url']] = $movie['title'];
}

//call vehiclelist method and form array 
$vehicles = $starwarsAPI->vehicleList(["https://swapi.dev/api/vehicles/?page=1","https://swapi.dev/api/vehicles/?page=2","https://swapi.dev/api/vehicles/?page=3","https://swapi.dev/api/vehicles/?page=4"]);


foreach($vehicles as $key=>$vehicle){
    if($key==0){
        $vehicle_name = $vehicle;
    }else{
        $vehicle_films = $vehicle;
    }
}
echo "<thead>";
echo "<tr>";
echo "<th>";
echo "Vehicle Name";
echo "</th>";
echo "<th>";
echo "Appears in Movie";
echo "</th>";
echo "</tr>";
echo "</thead>";
//loop through and display the vehicle name and the movies used in
foreach($vehicle_name as $vname){
    echo "<tr>";
    echo "<td>";
    echo $vname;
    echo "</td>";
    echo "<td>";
    if(array_key_exists($vname,$vehicle_films)){
        $vfilms = $vehicle_films[$vname];
        foreach($vfilms as $vfilm){
            if(array_key_exists($vfilm,$movie_name)){
                echo $movie_name[$vfilm]."<br>";
            }
        }
    }
    echo "</td>";
}
echo "</table>";
echo "</div>";
?>
</body>
</html>	