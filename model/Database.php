<?php

// REMEMBER TO REMOVE ECHOES BEFORE PUBLICING!

namespace model;

class Database {
    private $dbServer;
    private $dbUsername;
    private $dbPassword;
    private $dbName;
    private $connection;

    public function __construct ($dbServer, $dbName, $dbUsername, $dbPassword) {
        $this->dbServer = $dbServer;
        $this->dbName = $dbName;
        $this->dbUsername = $dbUsername;
        $this->dbPassword = $dbPassword;
        $this->connection = false;
    }

    public function connectToDatabase () {
        try {
            $this->connection = new \PDO('mysql:host=' . $this->dbServer . ';dbname=' . $this->dbName, $this->dbUsername, $this->dbPassword);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            return false;
        }
        return true;
    }

    public function checkIfUserExist ($username, $password) {
        try {
            $statement = $this->connection->prepare('SELECT * FROM users WHERE BINARY username = :username AND BINARY password = :password');
            $statement->execute(array('username' => $username, 'password' => $password));

            if ($statement->rowCount() > 0) {
                return true;
            }
        } catch (\PDOException $e) {

            return false;
        }
        return false;
    }

    public function registerNewUser ($username, $password, $hashedPassword) {
        try {
            $statement = $this->connection->prepare("INSERT INTO users (username, password, hashedPassword) VALUES ('$username', '$password', '$hashedPassword')");
            $statement->execute(array('username' => $username, 'password' => $password, 'hashedPassword' => $hashedPassword));
            
        } catch (\PDOException $e) {

            return false;
        }
        return true;
    }

    public function getHashedPassword ($username) {
        try {
            $statement = $this->connection->prepare("SELECT hashedPassword FROM users WHERE username LIKE '$username'");
            $statement->execute();

            $result = $statement->fetchColumn();
        } catch (\PDOException $e) {
            return false;
        }
        return $result;
    }

    public function verifyPassword ($username, $hashedPassword) { // REMEMBER WE HASH PASSWORD
        try {
            $statement = $this->connection->prepare("SELECT * FROM users WHERE username LIKE '$username' AND hashedPassword LIKE '$hashedPassword'");
            $statement->execute(array('username' => $username, 'password' => $password));

            if ($statement->rowCount() > 0) {
                return true;
            }

        } catch (\PDOException $e) {

            return false;
        }
        return false; 
    }

    public function updatePassword ($username, $password) {
        try {
            $statement = $this->connection->prepare("UPDATE users SET password = '$password' WHERE username = '$username'");
            $statement->execute(array('password' => $password));
            
        } catch (\PDOException $e) {

            return false;
        }
        return true;
    }

    public function updateHashedPassword ($username, $hashedPassword) {
        try {
            $statement = $this->connection->prepare("UPDATE users SET hashedPassword = '$hashedPassword' WHERE username = '$username'");
            $statement->execute();
            
        } catch (\PDOException $e) {

            return false;
        }
        return true;

    }

    public function deleteUser ($username, $password) {
        try {
            $statement = $this->connection->prepare('DELETE FROM users WHERE username = :username AND password = :password');
            $statement->execute(array('username' => $username, 'password' => $password));

        } catch (\PDOException $e) {

            return false;
        }
        return true;

    }
}
