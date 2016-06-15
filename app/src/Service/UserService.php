<?php

namespace Skeleton\Service;

use \Skeleton\Service\AbstractEntityService;
use \Skeleton\Library\UUID;
use \Skeleton\Library\Debug;
use \Skeleton\Model\Entity\UserEntity;
use \Doctrine\DBAL\Exception\UniqueConstraintViolationException;

/**
 * Class UserService
 * @package Skeleton\Service
 */
class UserService extends AbstractEntityService
{

    /**
     * @var array
     */
    protected $passwordHashCost = ['cost' => 12];

    /**
     * @param $formData
     * @return bool
     */
    public function createUser($formData)
    {
        $user = new UserEntity();
        $user->setEmail($formData['email']);

        $user->setFullName($formData['fullname']);
        $user->setPassword($this->hashPassword($formData['password']));
        $user->setPubUniqueId($this->generatePublicId());

        $this->em->persist($user);

        try {
            $this->em->flush();

            return true;
        } catch (UniqueConstraintViolationException $e) {
            return false;
        }
    }

    /**
     * @param $password
     * @return bool|string
     */
    protected function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT, $this->passwordHashCost);
    }

    /**
     * @return bool|string
     */
    protected function generatePublicId()
    {
        return UUID::v5(UUID::v4(), uniqid());
    }

    /**
     * @param null $pubUniqueId
     * @return array|null|object
     */
    public function get($pubUniqueId = null)
    {

        if (is_null($pubUniqueId)) {
            $users = $this->em->getRepository('Skeleton\Model\Entity\UserEntity')->findAll();
            $users = array_map(function ($users) {
                return $users->getArrayCopy();
            }, $users);

        } else {
            $users = $this->em->getRepository('Skeleton\Model\Entity\UserEntity')->findOneBy(array('pubUniqueId' => $pubUniqueId));
            if ($users) {
                $users = $users->getArrayCopy();
            }
        }

        return $users;
    }
}
