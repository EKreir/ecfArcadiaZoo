# ecfArcadiaZoo
master branch : final project

dev branch : development environment

project deployed in Hostinger vps (server) : http://srv636593.hstgr.cloud:81/

project deployed in Hostinger web host : https://arcadia.press/

# to deploy the project locally, you must configure the workspace: 

1. install php, mysql (or other database server, ex.: psotgresql, mariadb,...), apache in terminal (check docs for each language for installation in different os),

- check the php and mysql installations: `php -v` or `php --version`, the same for mysql in terminal,

2. create an account (user & password) in mysql server cli in terminal,

3. create a database either in the terminal so on the command line or using phpmyadmin but you have to install and configure it,

4. download the zip in master branch,
- in the .zip there is a sql file to import in phpmyadmin to have the same data from the db,

5. install the php dependency manager: Composer in terminal (check doc for Composer),

6. install Mongodb (pecl) extension for php in terminal,

- include: "extension=mongodb.so" in the php.ini file to activate the mongodb extension in its php environment,

7. install phpmailer for email management and install mailpit or other smtp (look at the doc for mailpit & once installed, it musts run for successful sending),

optional: install phpdotenv to integrate an .env file for the php file which manages reading of the database,

8. install mongodb, mongodb shell & mongodb compass to create a non-relational database (check the doc),

9. modify the values ​​in the mysql and mongodb database connection files with yours (user, password, host, dbname,...),

- be careful, the identifiers (user, password, etc...) must be modified in the .env file or otherwise put these values ​​in the db.php file,

10. launch the apache service,

- and finally, all that remains is to test locally to visualize the project.

# with git : 

clone the project :

`git clone https://github.com/EKreir/ecfArcadiaZoo.git`

go to directory :

`cd directory_name`

then execute : 

`git checkout master` for master branch or `git checkout dev` for dev branch (because the main branch is empty)

then install composer (if not done, for managing dependencies and libraries) : 

for my part I have a linux distribution (ubuntu 24.04) `sudo apt install composer`

- and finally, all that remains is to test locally to visualize the project.
