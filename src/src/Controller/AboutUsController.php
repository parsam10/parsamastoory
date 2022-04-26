<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutUsController extends AbstractController
{
    /**
     * @Route("/about")
     */
    public function about(): Response
    {
        $createdDate = "2022/04/23";
        $companyAddress = "Karaj/Hesarak/...";
        $version = "0.1 'Demo'";

        return $this->render('about/about_us.html.twig' ,[
            'CreatedDate' => $createdDate,
            'Address' => $companyAddress,
            'Version' => $version,
        ] );
    }
}