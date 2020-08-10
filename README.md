# starwars_api
Processing starwars api and getting necessary data
Notes
- Access the SWAPI public API, located at https://swapi.dev/
- Will pass HTML validation checks.
- Logs show what data is being processed, and what occurs during the
processing of your request (example; full requests and responses).

Tasks
1. Create a .html file (named '<FirstnameLastname>.html').
Ensure all files you create in the following tasks are linked from this file.
Example: iyappan.html
2. Create a PHP script named characters_jedi.php which lists all character names in the film
'Return Of The Jedi'.
3. Create a PHP file named mammal_homeworlds.php that lists all 'mammals' (species) in all
Star Wars films, and the name of their homeworld.
4. Create a database table of all ‘characters’ in all Star Wars films.
Your database should be named ‘<FirstnameLastname>_Characters’.
This table should contain the following required fields (you will decide the data types for the
fields):
  - name
  - height
  - mass
  - hair_color
  - skin_color
  - eye_color
  - birth_year
  - gender
  - created
  - homeworld_name (name of their homeworld)
  - species_name
5. Create a PHP file (named import_characters.php ) to populate the database table you have
created in Step 4, with all characters available in the API. This code needs to call the remote
API directly.
6. Create new database table by executing the sql script ‘CharacterUpdates.sql’ (see below).
7. Create a PHP file named update_characters.php , which updates the data in your database
table (which you created in Task 4) with the data provided in table 'CharacterUpdates', which
was created in Step 6.
8. List the name of all vehicles that can have more than 30 characters, and for each matching
vehicle, provide the name of the film they appear in.
9. Create a method which can be used to add characters to your characters table.
10.For this method, create a web form which allows users to create characters. This form should
have Javascript validation before submitting the form, and display any validation / error
messages to the user.
SQL Script For Step 6
CREATE TABLE `CharacterUpdates` (
`id` MediumInt( 9 ) AUTO_INCREMENT NOT NULL,
`name` VarChar( 191 ) NOT NULL,
`height` Smallint( 6 ) NOT NULL,
`mass` VarChar( 100 ) NOT NULL,
`hair_color` VarChar( 191 ) NOT NULL,
`skin_color` VarChar( 191 ) NOT NULL,
`eye_color` VarChar( 191 ) NOT NULL,
`birth_year` VarChar( 191 ) NOT NULL,
`gender` VarChar( 191 ) NOT NULL,
`created` Timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
`homeworld_name` VarChar( 100 ) NOT NULL,
`species_name` VarChar( 100 ) NOT NULL,
PRIMARY KEY ( `id` ),
CONSTRAINT `name` UNIQUE( `name` )
);
INSERT INTO
`CharacterUpdates`(`id`,`name`,`height`,`mass`,`hair_color`,`skin_color`,`eye_color`,`b
irth_year`,`gender`,`created`,`homeworld_name`,`species_name`) VALUES ( '2', 'C-3PO',
'167', '75', 'n/a', 'gold', 'yellow', '112BBY', 'female', '2019-01-02 13:29:10',
'Pluto', 'Kangaroo' );
INSERT INTO
`CharacterUpdates`(`id`,`name`,`height`,`mass`,`hair_color`,`skin_color`,`eye_color`,`b
irth_year`,`gender`,`created`,`homeworld_name`,`species_name`) VALUES ( '3', 'R2-D2',
'96', '32', 'n/a', 'white, blue', 'red', '33BBY', 'female', '2019-01-02 13:29:10',
'Venus', 'Chimpanzee' );
INSERT INTO
`CharacterUpdates`(`id`,`name`,`height`,`mass`,`hair_color`,`skin_color`,`eye_color`,`b
irth_year`,`gender`,`created`,`homeworld_name`,`species_name`) VALUES ( '13',
'Chewbacca', '228', 'testing!', 'brown', 'unknown', 'blue', '200BBY', 'male',
'2019-01-02 13:29:40', 'Mars', 'Wombat' );
INSERT INTO
`CharacterUpdates`(`id`,`name`,`height`,`mass`,`hair_color`,`skin_color`,`eye_color`,`b
irth_year`,`gender`,`created`,`homeworld_name`,`species_name`) VALUES ( '19', 'Yoda',
'66', '17', 'white', 'green', 'brown', '896BBY', 'male', '2019-01-02 13:29:40',
'Saturn', 'Elephant' );
