--
-- Create database with the specified name
--
CREATE DATABASE IF NOT EXISTS iyappankrishnasamy_characters;
--
-- use created db
--
use iyappankrishnasamy_characters;
--
-- Table structure for table `characters`
--

CREATE TABLE `Characters` (
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
`homeworld` VarChar( 100 ) NOT NULL,
`species` VarChar( 100 ) NOT NULL,
PRIMARY KEY ( `id` ),
CONSTRAINT `name` UNIQUE( `name` )
)ENGINE=InnoDB DEFAULT CHARSET=latin1;
