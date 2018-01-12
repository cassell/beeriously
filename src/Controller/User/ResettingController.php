<?php

declare(strict_types=1);

namespace Beeriously\Controller\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ResettingController extends \FOS\UserBundle\Controller\ResettingController
{
    /**
     * @Route("/resetting/request", name="fos_user_resetting_request", methods={"GET"})
     */
    public function requestAction()
    {
        return $this->render('user/security/resetting/request.html.twig');
    }

    /**
     * @Route("/resetting/send-email", name="fos_user_resetting_send_email", methods={"POST"})
     */
    public function sendEmailAction(Request $request)
    {
        return parent::sendEmailAction($request);
    }

    /**
     * @Route("/resetting/check-email", name="fos_user_resetting_check_email", methods={"GET"})
     */
    public function checkEmailAction(Request $request)
    {
        return parent::checkEmailAction($request);
    }

    /**
     * @Route("/reset/{token}", name="fos_user_resetting_reset", methods={"GET","POST"})
     */
    public function resetAction(Request $request, $token)
    {
        return parent::resetAction($request, $token);
    }
}
