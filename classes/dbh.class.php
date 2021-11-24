<?php

class Dbh
{
    protected function connect()
    {
        try {

            $username = "root";
            $password = "";
            $db_name = "wholesale";
            $dbh = new PDO('mysql:host=localhost;dbname='.$db_name, $username, $password);

            return $dbh;

        } catch (PDOException $e) {

            print "Error!: " . $e->getMessage() . "<br>";
            die;
            
        }
    }
}
