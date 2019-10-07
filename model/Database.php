<?php

namespace model;

class Database {
    private $servername;
    private $dbUsername;
    private $dbPassword;
    private $dbName;
    private $connection;

    public function __construct ($servername, $dbUsername, $dbPassword, $dbName) {
        $this->servername = $servername;
        $this->dbUsername = $dbUsername;
        $this->dbPassword = $dbPassword;
        $this->dbName = $dbName;
        $this->connection = false;
    }

    // PDO has an exception class to handle any problems in our database queries
    public function connectToDatabase () : bool {
        try {
            $this->connection = new PDO('mysqli:host=' . $this->servername . ';dbname=' . $this->dbName, $this->$dbUsername, $this->dbPassword);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            return false;
        }
        echo 'Connected successfully';
        return true;
    }

    public function checkIfUserExist ($username, $password) : bool {
        try {
            $statement = $this->connection->prepare('SELECT * FROM users WHERE username = :username AND password = :password');
            $statement->execute(array('username' => $username, 'password' => $password));

            if ($statement->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            echo 'User does not exist in database: ' . $e->getMessage();
            return false;
        }
        return false;
    }

    public function registerNewUser ($username, $password) : bool {
        try {
            $statement = $this->connection->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
            $statement->execute(array('username' => $username, 'password' => $password));
        } catch (PDOException $e) {
            echo 'User could not be added to database: ' . $e->getMessage();
            return false;
        }
        return true;
    }
}
