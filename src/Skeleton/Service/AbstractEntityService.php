<?php

namespace Skeleton\Service;

use Doctrine\ORM\EntityManager;
use Skeleton\Exception\SkeletonException;
use Skeleton\Constants\SkeletonExceptionConstants as e;

/**
 * Class AbstractEntityService
 * @package Skeleton\Service
 * @author Renato Rodrigues de Araujo <renato.r.araujo@gmail.com>
 * @todo basics extends of database interactions
 */
abstract class AbstractEntityService
{
    /**
     * @access protected
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager = null;

    /**
     * @access protected
     * @var string $strEntity
     */
    protected $strEntity;

    /**
     * @access protected
     * @var string $strServiceName
     */
    protected $strServiceName;

    /**
     * AbstractEntityService constructor.
     * @access public
     * @param EntityManager $entityManager
     * @param array|null $options
     */
    public function __construct(EntityManager $entityManager, array $options = null)
    {
        $this->setEntityManager($entityManager);

        if (!empty($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * Set options for service
     * @access protected
     * @example $this->setOptions(['strEntity' => '\MyApp\Entity\MyEntityClass']);
     * @param array $options
     */
    protected function setOptions(array $options)
    {
        foreach ($options as $optionKey => $optionValue) {
            if (!property_exists($this, $optionKey)) {
                trigger_error(sprintf(e::WAR_PROPERTY_NOT_EXISTS_MSG, $optionKey), E_USER_WARNING);
            }

            $this->$optionKey = $optionValue;
        }
    }

    /**
     * Set the entity manager
     * @access protected
     * @param $entityManager
     * @return $this
     */
    protected function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * Get the entity manager
     * @access protected
     * @return EntityManager
     * @throws SkeletonException
     */
    protected function getEntityManager()
    {
        if(empty($this->entityManager)) {
            throw new SkeletonException(e::ERR_EM_NOT_SET_MSG, e::ERR_EM_NOT_SET_CODE);
        }

        return $this->entityManager;
    }

    /**
     * Get the repository entity given or setted in options on constructor/setOptions method
     * @access protected
     * @param string $strEntity
     * @example $this->getRepositoryEntity('\MyApp\Entity\MyEntityClass');
     * @return \Doctrine\ORM\EntityRepository
     * @throws SkeletonException
     */
    protected function getRepositoryEntity($strEntity = null)
    {
        if (empty($strEntity)) {
            if (!$this->strEntity) {
                $this->setRepositoryFromServiceName();
                throw new SkeletonException(e::ERR_REPOSITORY_NOT_SET_MSG, e::ERR_REPOSITORY_NOT_SET_CODE);
            }

            $strEntity = $this->strEntity;
        }

        if($strEntity) {
            if ($this->validateGivenClass($strEntity)) {
                return $this->getEntityManager()->getRepository($strEntity);
            }
        }
    }

    /**
     * Validate if the given class exists
     * @access protected
     * @param $strClassName
     * @return bool
     * @throws SkeletonException
     */
    protected function validateGivenClass($strClassName)
    {
        if (!class_exists($strClassName)) {
            throw new SkeletonException(e::ERR_INVALID_CLASS_MSG, e::ERR_INVALID_CLASS_CODE);
        }

        return true;
    }

    /**
     * Try to set repository class from service name given in options
     * @access private
     * @throws SkeletonException
     * @return bool
     */
    private function setRepositoryFromServiceName()
    {
        $isRepositorySet = false;

        if (!empty($this->strServiceName)) {
            if ($this->validateGivenClass($this->strServiceName)) {
                $this->strEntity = str_replace('\Service', '\Entity', $this->strServiceName);
                $this->strEntity = str_replace('Service', '', $this->strServiceName);
            }

            $isRepositorySet = true;
        }

        return $isRepositorySet;
    }
}
