<?php

class SignupContr extends Signup {

    private $name;
    private $type;
    private $email;
    private $password;
    private $created_at;
    private $updated_at;

    public function __construct($name, $type, $email, $password, $created_at, $updated_at = NULL)
    {
        $this->name = $name;
        $this->type = $type;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = $created_at;
        if ($updated_at != NULL) {
            $this->updated_at = $updated_at;
        }
    }

    public function signupUser() 
    {
        if ($this->emptyInput() == false) {
            header("location: ../signup.php?error=emptyinput");
            exit;
        }
        if ($this->invalidEmail() == true) {
            header("location: ../signup.php?error=invalidemail");
            exit;
        }
        if ($this->emailMatch() == true) {
            header("location: ../signup.php?error=emailmatch");
            exit;
        }

        $this->setUser($this->name, $this->type, $this->email, $this->password, $this->created_at, $this->updated_at);
    }

    private function emptyInput()
    {
        $result = false;
        if (empty($this->name) || empty($this->type) || empty($this->email) || empty($this->password)) {
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

    private function emailMatch()
    {
        $result = true;
        if (!$this->checkUser($this->email)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

}