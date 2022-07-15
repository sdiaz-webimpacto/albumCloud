<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends LayoutController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        if(empty($this->getUser()))
        {
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        $photos = $user->getPhotos();
        $userPhotos = array();
        if(count($photos) >= 10)
        {
            $num = 10;
        } else {
            $num = count($photos);
        }

        for($i = count($photos) - 1; $i >= count($photos) - $num; $i--)
        {
            $userPhotos[] = $photos[$i];
        }
        $albumes = $this->getUser()->getAlbumes();

        $data = parent::index($request);
        $data['albumes'] = $albumes;
        $data['photos'] = $userPhotos;
        return $this->render('home/index.html.twig', $data);
    }
}
