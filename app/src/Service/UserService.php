<?php

namespace Skeleton\Service;

use \Skeleton\Service\AbstractEntityService;

class UserService extends AbstractEntityService
{
  /**
  *
  * @return array
  */
  public function get()
  {
    $users = $this->em->getRepository('Skeleton\Model\Entity\UserEntity')->findAll();
    $users = array_map(
      function ($users) {
        return $users->getArrayCopy();
      }, $users
    );

    return $users;
  }
}
