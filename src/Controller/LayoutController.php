<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LayoutController extends AbstractController
{
    #[Route('/layout', name: 'app_layout')]
    public function index(Request $request)
    {
        if($this->getUser())
        {
            $name = $this->getUser();
        } else {
            $name = 'Entrar';
        }
        return array(
        'header' => $name->getUserName(),
        'user' => $name,
        'footer' => 'Fecha '.date('d-m')
        );
    }
}
