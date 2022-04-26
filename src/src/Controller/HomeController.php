<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(): Response
    {
        $companyName = "PM10";
        $purpose = "Show you Tourist points";
        $city = "Karaj";

        return $this->render('home/home.html.twig',[
            'CompanyName' => $companyName,
            'Purpose' => $purpose,
            'City' => $city,
        ] );
    }
}