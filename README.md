# Assignment 2 and 4 for the course 1DV610
###### Author: Emma Källström

## How to install
##### Programming language: PHP
### Local instructions:
To locally use and test this code with its database you need to use mysql and have MAMP, WAMP or LAMP installed on your computer. 

You need to create a file, which you let .gitignore handle as it will hold your credentials for mysql. Set the database credentials to the same variable names which are located in index.php (dbServer, dbName and so on). When its done, include this file in index.php so the database will access your credentials. 

Don't forget to remove or comment out the previous file included.

### Public instructions:
If you wish to use and test this code on a public web server, e.g Heroku where this repository is deployed, you need another database than your local mysql. In this assignment ClearDB is used as database when working live. To setup your own ClearDB and migrate from your local mysql, you could use Sequel Pro. More documentation on how to could easily be found within a web search.

## How to test
This assignment can either be tested automatically if you've uploaded it to a public web server, or with its test cases which are presented within the folder [*Documentation*](https://github.com/codesis/1dv610_L2/tree/master/Documentation). The automated test service can be found [*here*](http://csquiz.lnu.se:25083/index.php "Automated Test Application").
