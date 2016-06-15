<?php
namespace Skeleton\Model\Entity;

use \Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Skeleton\Model\Repository\UserRepository")
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})}))
 */
class UserEntity
{

    /**
     * @ORM\Id
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $userId;

    /**
     * @ORM\Column(name="full_name", type="string", length=100, nullable=false)
     */
    protected $fullName;

    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=60, nullable=false)
     */
    protected $password;

    /**
     * @ORM\Column(name="pub_unique_id", type="string", length=36, nullable=false)
     */
    protected $pubUniqueId;

    /**
     * Get array copy of object
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * Get user id
     *
     * @ORM\return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Get full name
     *
     * @ORM\return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Get user email
     *
     * @ORM\return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get user password
     *
     * @ORM\return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *
     * @ORM\return string
     */
    public function getPubUniqueId()
    {
        return $this->pubUniqueId;
    }

    /**
     * @param mixed $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $pubUniqueId
     */
    public function setPubUniqueId($pubUniqueId)
    {
        $this->pubUniqueId = $pubUniqueId;
    }

}
