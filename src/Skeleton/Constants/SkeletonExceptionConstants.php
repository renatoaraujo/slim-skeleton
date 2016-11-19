<?php

namespace Skeleton\Constants;

/**
 * Interface SkeletonExceptionConstants
 * Define the Exceptions code and messages to display according the documentation
 * @package Skeleton\Constants
 */
interface SkeletonExceptionConstants
{
    # Exception errors
    const ERR_EM_NOT_SET_MSG = 'Error: Entity Manager was not set properly';
    const ERR_EM_NOT_SET_CODE = 0001;

    const ERR_REPOSITORY_NOT_SET_MSG = 'Error: Repository class was not set properly';
    const ERR_REPOSITORY_NOT_SET_CODE = 0002;

    const ERR_INVALID_CLASS_MSG = 'Error: The class %s does not exists.';
    const ERR_INVALID_CLASS_CODE = 0003;

    const ERR_OBJ_AS_STRING_OR_ANON_MSG = "Error: Use only Object as string or Anonymous functions.";
    const ERR_OBJ_AS_STRING_OR_ANON_CODE = 0004;

    const ERR_MISSING_HTTP_METHOD_ROUTE_MSG = "Error: You need to declare the HTTP method in route %s";
    const ERR_MISSING_HTTP_METHOD_ROUTE_CODE = 0005;

    const ERR_MISSING_URL_ROUTE_MSG = "Error: Please specify the URL in route %s";
    const ERR_MISSING_URL_ROUTE_CODE = 0006;

    const ERR_MISSING_CALLBACK_ROUTE_MSG = "Error: you need to declare the callback in route %s";
    const ERR_MISSING_CALLBACK_ROUTE_CODE = 0007;

    # Warnings
    const WAR_PROPERTY_NOT_EXISTS_MSG = 'Warning: Property is not defined. Ignoring %s';
}
