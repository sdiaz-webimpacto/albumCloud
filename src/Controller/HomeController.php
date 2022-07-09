<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends LayoutController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        if(empty($this->getUser()))
        {
            return $this->redirectToRoute('app_login');
        }
        $data = parent::index();
        $data['datos'] = 'Datos de este controlador';
        return $this->render('home/index.html.twig', $data);
    }
}
