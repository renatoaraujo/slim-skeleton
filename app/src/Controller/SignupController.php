<?php

namespace Skeleton\Controller;

use \Skeleton\Controller\AbstractSkeletonController;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Skeleton\Library\Debug;

/**
 * Class SigninController
 * @package Skeleton\Controller
 */
class SignupController extends AbstractSkeletonController
{

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return mixed
     */
    public function renderSignupPage(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->setParams('route', 'signup');
        $this->setHtmlFile("signup");
        return $this->render($response);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return mixed
     */
    public function signupFormAction(ServerRequestInterface $request, ResponseInterface $response)
    {

        $fullname = $request->getParam('fullname');
        $email = $request->getParam('email');
        $password = $request->getParam('password');

        if (!empty($fullname) && !empty($email) && !empty($password)) {
            $cleanName = filter_var($fullname, FILTER_SANITIZE_STRING);
            $cleanEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

            $createUser = $this->ci->userService->createUser([
                'fullname' => $cleanName,
                'email' => $cleanEmail,
                'password' => $password,
            ]);

            if (!$createUser) {
                $this->setParams('error', true);
                $this->setParams('message', "This email already been taken.");
                $this->setHtmlFile("signup");
            } else {
                $this->setHtmlFile("signup_confirmation");
            }


        } else {
            $this->setParams('error', true);
            $this->setParams('message', "All fields are required.");
            $this->setHtmlFile("signup");
        }

        $this->setParams('route', 'signup');

        return $this->render($response);
    }
}