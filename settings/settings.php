<?php

/**
 * Settings
 * 
 * Holds the paths in Heroku to the database credentials @ ClearDB
 */

$dbName = getenv('dbName');
$dbPassword = getenv('dbPassword');
$dbServer = getenv('dbServer');
$dbUsername = getenv('dbUsername');
