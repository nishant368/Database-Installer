# Database Installer

## NAME 

Database Installer

## DESCRIPTION 

**Database-Installer** performs installation of MySQL databases by php scripts.
Features:

  - Install databases
  - Check existence of tables in mysql database
  - Delete existing mysql database
  - Re-install mysql database
  - more...

## CONFIGURATION FILE

### Default configuration

**Database-Installer** looks for a default file structure in the given order:

  - 'database-installer/index.php'
  - 'database-installer/jquery-2.1.3.min.js'
  - 'database-installer/mysql.sql'


## How to use?  

Step 1::

  Put all the files in a folder named database-installer as the file structure shown above

Step 2::

  Replace the mysql.sql file with your database .sql file(database which have to be installed) and rename your database(example.sql file) to mysql.sql

Step 3::

  Place the database-installer folder in root of your website
  like- yoursite.com/database-installer
  and run this url in your browser. 
  
Step 4::

  It will require mysql databse hostname, mysql databse name, mysql databse username, mysql databse password to install the mysql.sql database.
  And if the database will already consists tables then it will ask for delete the existing tables and after that new database(mysql.sql) can be install. 


## HISTORY

### Version 1.0

2015-03-07::

  First release.

== AUTHORS ==

**Database-Installer** is written by Nishant Kumar.
