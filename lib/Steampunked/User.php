<?php
/**
 * Created by PhpStorm.
 * User: Mateen
 * Date: 4/11/2016
 * Time: 1:05 PM
 */

namespace Steampunked;


class User
{
    const SESSION_NAME = 'user';
    const ADMIN = "A";
    const Gamer = "G";
    /**
     * Constructor
     * @param $row Row from the user table in the database
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->email = $row['email'];
        $this->name = $row['name'];
        $this->role = $row['role'];
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }
    /**
     * @return mixed
     */
     public function getEmail()
    {
        return $this->email;
    }
    /**
     * Determine if user is a staff member
     * @return bool True if user is a staff member
     */
    public function isGamer() {
        return $this->role === self::ADMIN ||
        $this->role === self::Gamer;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    private $id;		///< The internal ID for the user
    private $email;		///< Email address
    private $name; 		///< Name as last, first
    private $role;		///< User role

}