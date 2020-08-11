<?php

class User
{
    private $firstName;
    private $lastName;
    private $email;
    private $password;

    public function __construct($firstName, $lastName, $email, $password)
    {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * The email address should end with '@student.thomasmore.be'
     */
    public function setEmail($email)
    {
        $domainNameStartIndex = strpos($email, '@');
        $domainName = substr($email, $domainNameStartIndex);

        if ($domainName !== '@student.thomasmore.be') {
            throw new Exception('Email address must end with @student.thomasmore.be');
        }

        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    /**
     * The password must contain 5 characters
     *
     * Using Bcrypt to hash the password. It currently is the default algorithm used with the password_hash function.
     * It automatically generates a salt and the option 'rounds' can be passed to counter Moore's law.
     */
    public function setPassword($password)
    {
        if (strlen($password) < 5) {
            throw new Exception('Password must contain 5 characters');
        }

        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
}
