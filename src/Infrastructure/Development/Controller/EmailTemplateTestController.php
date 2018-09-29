<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\Development\Controller;

use Beeriously\Infrastructure\Controller\AbstractController;
use Beeriously\Tests\Helpers\TestBreweryBuilder;
use Symfony\Component\Routing\Annotation\Route;

class EmailTemplateTestController extends AbstractController
{
    /**
     * @Route("/dev/email/registration", methods={"GET"})
     */
    public function registrationConfirmation()
    {
        $brewery = TestBreweryBuilder::createBrewery();
        $owner = TestBreweryBuilder::getOwner($brewery);

        //  /us/dev/email/registration
        return $this->render('@FOSUser/Registration/email.txt.twig', [
            'user' => $owner,
            'confirmationUrl' => 'https://.../confirmation',
        ]);
    }

    /**
     * @Route("/dev/email/resetting", methods={"GET"})
     */
    public function resetting()
    {
        $brewery = TestBreweryBuilder::createBrewery();
        $owner = TestBreweryBuilder::getOwner($brewery);

        //  /us/dev/email/registration
        return $this->render('@FOSUser/Resetting/email.txt.twig', [
            'user' => $owner,
            'confirmationUrl' => 'https://.../resetting',
        ]);
    }
}
