<?php

namespace Skeleton\Service;

use \Doctrine\ORM\EntityManager;

abstract class AbstractEntityService
{

  /**
  * @var \Doctrine\ORM\EntityManager
  */
  protected $em = null;

  public function __construct(EntityManager $entityManager)
  {
    $this->em = $entityManager;
  }

} ?>
