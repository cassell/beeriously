<?php
declare(strict_types=1);

namespace Beeriously\Controller\User;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;

class SecurityController extends \FOS\UserBundle\Controller\SecurityController
{
    /**
     * @Route("/login", name="fos_user_security_login", methods={"GET","POST"})
     */
    public function loginAction(Request $request)
    {
        return parent::loginAction($request);
    }


    protected function renderLogin(array $data)
    {
        return $this->render('user/security/login.html.twig', $data);
    }

    /**
     * @Route("/login_check", name="fos_user_security_check",  methods={"POST"})
     */
    public function checkAction()
    {
        parent::checkAction();
    }

    /**
     * @Route("/logout", name="fos_user_security_logout", methods={"GET","POST"})
     */
    public function logoutAction()
    {
        parent::logoutAction();
    }


}