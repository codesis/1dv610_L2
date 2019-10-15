<?php

// dont forget to make these reachable for heroku

// $dbServer = 'localhost';
// $dbUsername = 'mamp';
// $dbPassword = 'liSwn3MIGPo7x0HI';
// $dbName = 'lab3';

// $db_Server = 'us-cdbr-iron-east-05.cleardb.net';
// $db_Database = 'heroku_a39974d544006a2';
// $db_Username = 'bf785be26b0298';
// $db_password = '286c1fcf';

$dbName = getenv('dbName');
$dbPassword = getenv('dbPassword');
$dbServer = getenv('dbServer');
$dbUsername = getenv('dbUsername');
