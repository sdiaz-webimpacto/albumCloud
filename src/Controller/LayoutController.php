<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LayoutController extends AbstractController
{
    #[Route('/layout', name: 'app_layout')]
    public function index()
    {
        return array(
        'header' => rand(1,100),
        'footer' => 'Fecha '.date('d-m')
        );
    }
}
