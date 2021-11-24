<?php

class Signup extends Dbh {

    protected function setUser($name, $type, $email, $password, $created_at, $updated_at)
    {
        $db = $this->connect();

        $query = $db->prepare("INSERT INTO users (name, type, email, password, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?);");

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (!$query->execute(array($name, $type, $email, $hashedPassword, $created_at, $updated_at))) {
            $query = null;
            header("location: ../signup.php?error=queryfailed");
            exit;
        }

        $query = null;
    }

    protected function checkUser($email)
    {
        $db = $this->connect();

        $query = $db->prepare("SELECT id FROM users WHERE email = ?;");

        if (!$query->execute(array($email))) {
            $query = null;
            header("location: ../signup.php?error=queryfailed");
            exit;
        }

        $resultCheck = false;
        if ($query->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }
        $query = null;

        return $resultCheck;
    }

}