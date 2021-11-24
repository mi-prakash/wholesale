<?php

class Login extends Dbh {

    protected function getUser($email, $password)
    {
        $db = $this->connect();

        $query = $db->prepare("SELECT password FROM users WHERE email = ?;");

        if (!$query->execute(array($email))) {
            $query = null;
            header("location: ../login.php?error=queryfailed");
            exit;
        }

        if ($query->rowCount() == 0) {
            $query = null;
            header("location: ../login.php?error=usernotfound");
            exit;
        }

        $hashedPassword = $query->fetchAll(PDO::FETCH_ASSOC);
        $checkPassword = password_verify($password, $hashedPassword[0]['password']);

        if ($checkPassword == false) {
            $query = null;
            header("location: ../login.php?error=wrongpassword");
            exit;
        } elseif ($checkPassword == true) {
            $query = $db->prepare("SELECT * FROM users WHERE email = ? AND password = ?;");

            if (!$query->execute(array($email, $hashedPassword[0]['password']))) {
                $query = null;
                header("location: ../login.php?error=queryfailed");
                exit;
            }

            if ($query->rowCount() == 0) {
                $query = null;
                header("location: ../login.php?error=usernotfound");
                exit;
            }

            $user = $query->fetchAll(PDO::FETCH_ASSOC);

            session_start();
            $_SESSION['id'] = $user[0]['id'];
            $_SESSION['name'] = $user[0]['name'];
            $_SESSION['email'] = $user[0]['email'];
            $_SESSION['type'] = $user[0]['type'];
        }

        $query = null;
    }

}