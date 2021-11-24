<?php

class LoginContr extends Login {

    private $email;
    private $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function loginUser() 
    {
        if ($this->emptyInput() == false) {
            header("location: ../login.php?error=emptyinput");
            exit;
        }
        if ($this->invalidEmail() == true) {
            header("location: ../signup.php?error=invalidemail");
            exit;
        }

        $this->getUser($this->email, $this->password);
    }

    private function emptyInput()
    {
        $result = false;
        if (empty($this->email) || empty($this->password)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidEmail()
    {
        $result = true;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

}