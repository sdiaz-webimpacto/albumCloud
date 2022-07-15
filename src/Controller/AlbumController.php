<?php

namespace App\Controller;

use App\Entity\Albumes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends LayoutController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/album/{id}', name: 'app_album')]
    public function index(Request $request): Response
    {
        if(empty($this->getUser()))
        {
            return $this->redirectToRoute('app_login');
        }

        $em = $this->entityManager;
        $id = $request->get('id');
        $album = $em->getRepository(Albumes::class)->find($id);
        $data = parent::index($request);
        $data['photos'] = $album->getPhotos();
        return $this->render('album/index.html.twig', $data);
    }
}
