<?php

namespace Skeleton\Service;

use \Skeleton\Service\AbstractEntityService;

class UserService extends AbstractEntityService
{
  /**
  *
  * @return array
  */
  public function get($pubUniqueId = null)
  {

    if(is_null($pubUniqueId)) {
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
