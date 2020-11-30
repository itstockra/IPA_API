
<?php

//Create DB class
//Used to connect to beersDB for each request

class db {
    //Properties
    private $dbhost = 'localhost';
    private $dbuser = 'phpmyadmin';
    private $dbpass = 'sqlpass';
    private $dbname = 'beersDB';

    //Connect to beersDB
    public function connect() {
        $mysqlConnectString = "mysql:host=$this->dbhost;dbname=$this->dbname;";
        $dbConnection = new PDO($mysqlConnectString, $this->dbuser, $this->dbpass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
}



?>