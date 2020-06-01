<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Asserts;

class Contact {
    /**
     * @var string|null
     * @Assert\NotBlalank()
     * Assert\Length(min=2, max=100)
     */

    private $firstname;

    /**
     * @var string|null
     * @Assert\NotBlalank()
     * Assert\Length(min=2, max=100)
     */
    private $lastname;

        /**
     * @var string|null
     * @Assert\NotBlalank()
     * Assert\Regex(
     * pattern="/[0-9]{10}"
     * )
     */
    private $phone;

    /**
     * @var string|null
     * @Assert\NotBlalank()
     * Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlalank()
     * Assert\Length(min=10)
     */
    private $message;

    /**
     * @var Property|null
     */
    private $property;
    
    /**
     * Get assert\Length(min=10)
     *
     * @return  string|null
     */ 
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set assert\Length(min=10)
     *
     * @param  string|null  $message  Assert\Length(min=10)
     *
     * @return  self
     */ 
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get assert\Email()
     *
     * @return  string|null
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set assert\Email()
     *
     * @param  string|null  $email  Assert\Email()
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get assert\Regex(
     *
     * @return  string|null
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set assert\Regex(
     *
     * @param  string|null  $phone  Assert\Regex(
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get assert\Length(min=2, max=100)
     *
     * @return  string|null
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }


    /**
     * Get the value of property
     *
     * @return  Property|null
     */ 
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set the value of property
     *
     * @param  Property|null  $property
     *
     * @return  self
     */ 
    public function setProperty($property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }
}
