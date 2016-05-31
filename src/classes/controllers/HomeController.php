<?php
namespace Skeleton\Controller;

use Skeleton\Controller\SkeletonController;

class HomeController extends SkeletonController
{

    public function testing($request, $response, $args)
    {
        $params = [];
        return $this->ci->view->render($response, 'index.html', $params);
    }
}
