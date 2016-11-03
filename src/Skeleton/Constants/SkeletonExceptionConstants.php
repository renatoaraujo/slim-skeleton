<?php

namespace Skeleton\Constants;

/**
 * Interface SkeletonExceptionConstants
 * Define the Exceptions code and messages to display according the documentation
 * @package Skeleton\Constants
 */
interface SkeletonExceptionConstants
{
    const ERR_EM_NOT_SET_MSG = 'Error: Entity Manager was not set properly';
    const ERR_EM_NOT_SET_CODE = 0001;

    const WAR_PROPERTY_NOT_EXISTS_MSG = 'Warning: Property is not defined. Ignoring %s';

    const ERR_REPOSITORY_NOT_SET_MSG = 'Error: Repository class was not set properly';
    const ERR_REPOSITORY_NOT_SET_CODE = 0002;

    const ERR_INVALID_CLASS_MSG = 'Error: The class %s does not exists.';
    const ERR_INVALID_CLASS_CODE = 0003;
}