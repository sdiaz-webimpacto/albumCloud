<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LayoutController extends AbstractController
{
    #[Route('/layout', name: 'app_layout')]
    public function index()
    {
        if($this->getUser())
        {
            $name = $this->getUser()->getUserName();
        } else {
            $name = 'Entrar';
        }
        return array(
        'header' => $name,
        'footer' => 'Fecha '.date('d-m')
        );
    }
}
