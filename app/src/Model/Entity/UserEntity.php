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
     * @ORM\Column(name="userId", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $userId;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $fullName;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=16)
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
}
